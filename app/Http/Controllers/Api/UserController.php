<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::findAll($this);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        return User::register($this, $request);
    }

    public function login(Request $request)
    {
        return User::login($this, $request);
    }

    public function islogin(Request $request)
    {
        return User::islogin($this, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edituser(Request $request)
    {
        $user = $this->checkAuth($request);
        if ($user === null) {
            $success['added'] = false;
            return $this->sendError('Fail to modify user.', $success);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $did = $user->save();

        if ($did === true) {
            // $success['added'] = true;
            $success['id'] = $user->id;
            $success['token'] = $user->token;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            return $this->sendResponse($success, 'User modified successfully.');
        }
        //$success['added'] = false;
        return $this->sendError('Fail to modify user.', "No changes made.");
    }

    private function checkAuth(Request $request)
    {
        $token = $request->bearerToken();
        return User::where('token', $token)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function editpass(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'o_password' => 'required|string|min:6',
                'password' => 'required|string|min:6',
                'c_password' => 'required|string|min:6|same:password',
            ]
        );
        if ($validator->fails()) {
            return $this->sendError('Validator Error', $validator->errors());
        }
        $user = $this->checkAuth($request);
        if ($user === null) {
            $success['added'] = false;
            return $this->sendError('Fail to modify user.', $success);
        }

        if (Auth::attempt(['email' => $user->email, 'password' => $request->input('o_password')])) {
            $usr = Auth::user();
            $user = User::find($usr->id);
            // bcrypt($input['password']);
            $user->password = Hash::make($request->input('password'));//bcrypt($request->input('password'));
            $user->token = hash('sha256', Str::random(60));
            $user->save();
            //$success['modified'] = true;
            $success['id'] = $user->id;
            $success['token'] = $user->token;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            return $this->sendResponse($success, 'User modified successfully.');
        }
        //$success['modified'] = false;
        return $this->sendError('Fail to modify user.', "No changes made.");
    }


    public function authtest(Request $request)
    {
        // $token = $request->header('Authorization');
        $token = $request->bearerToken();
        if ($token === null) return "Fail";
        // $token = $request->header('rdc-token');

        $user = User::where('token', $token)->first();
        return json_encode($user);
    }

    public function forgot_password2(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'email' => "required|email",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                    $message->subject($this->getEmailSubject());
                });
                switch ($response) {
                    case Password::RESET_LINK_SENT:
                        return Response::json(array("status" => 200, "message" => trans($response), "data" => array()));
                    case Password::INVALID_USER:
                        return Response::json(array("status" => 400, "message" => trans($response), "data" => array()));
                }
            } catch (\Swift_TransportException $ex) {
                $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            } catch (Exception $ex) {
                $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            }
        }
        return Response::json($arr);
    }
  
  
    public function forgot_password(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'email' => "required|email",
        );
        $arr = array();
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            $user = User::where('email', $request->input('email'))->first();
            if ($user === null) {
                $arr = array("status" => 400, "message" => "Email not found", "data" => array());
            } else {
                $num_str = sprintf("%03d", mt_rand(1, 999)) . '-' . sprintf("%03d", mt_rand(1, 999));// . '-' . sprintf("%03d", mt_rand(1, 999));

                $body_text = "Your password reset code is: " . $num_str . ".\n\nPlease use this code to ask for a reset of your password. This code will expire in 60 minutes.";
                $details = [
                    'subject' => "Password Reset",
                    'title' => "Password Reset : " . $num_str,
                    'body' => $body_text,
                ];

                // todo: before sending email save the code as token in the database, with email and token, expire in 60 minutes
                $token = Hash::make($num_str);
                $datum = array(
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                );

                $ress = DB::table('password_resets')->upsert([$datum], 'email');

                if ($ress) {
                    $rees = sendForgotPassMail($user->email, $details);
                    $arr = array("status" => 200, "message" => "Your password reset code has been sent to you email : " . $user->email, "data" => $rees);
                } else {
                    $arr = array("status" => 400, "message" => "Reset request not accepted", "data" => array());
                }
            }
        }
        return Response::json($arr);
    }
  
  
    public function password_reset_confirm_code(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'email' => "required|email",
            'code' => "required",
        );
        $arr = array();
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            $user = User::where('email', $request->input('email'))->first();
            if ($user === null) {
                $arr = array("status" => 400, "message" => "Email not found", "data" => array());
            } else {
                $ress = DB::table('password_resets')->where('email', $request->input('email'))->first();
                if ($ress === null) {
                    $arr = array("status" => 400, "message" => "Reset code not found", "data" => array());
                } else {
                    $code = $ress->token;
                    if ((Hash::check(request('code'), $code)) === true) {
                        $arr = array("status" => 200, "message" => "Reset code accepted", "data" => array());
                    } else {
                        $arr = array("status" => 400, "message" => "Reset code not accepted", "data" => array());
                    }
                }
            }

        }
        return Response::json($arr);
    }

    public function forgot_password_reset(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'email' => "required|email",
            'code' => "required",
            'password' => "required",
        );
        $arr = array();
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            $user = User::where('email', $request->input('email'))->first();
            if ($user === null) {
                $arr = array("status" => 400, "message" => "Password not reset because user not found", "data" => array());
            } else {
                $ress = DB::table('password_resets')->where('email', $request->input('email'))->first();
                if ($ress === null) {
                    $arr = array("status" => 400, "message" => "Password not reset because user did not request reset", "data" => array());
                } else {
                    $code = $ress->token;
                    if ((Hash::check(request('code'), $code)) === true) {
                        $user->password = Hash::make($request->input('password'));
                        $user->token = hash('sha256', Str::random(256));
                        $user->save();
                        $success['id'] = $user->id;
                        $success['token'] = $user->token;
                        $success['name'] = $user->name;
                        $success['email'] = $user->email;
                        DB::table('password_resets')->where('email', $request->input('email'))->delete();
                        $arr = array("status" => 200, "message" => "Password reset successfully", "data" => $success);
                      
                      
                        $success2['name'] = $user->name;
                        $success2['email'] = $user->email;
                        $success2['password'] = $request->input('password');
                      
                         $details = [
                            'subject' => 'Password reset',
                            'title' => 'Password reset successful',
                            'body' => "Your password has been reset successfully with the following details : ".json_encode($success2).". You can now login with your new password.",
                        ];
                        sendNormalMail($user->email, $details);
                    } else {
                        $arr = array("status" => 400, "message" => "Reset code not accepted", "data" => array());
                    }
                }
            }

        }
        return Response::json($arr);
    }

  
  

    public function change_password(Request $request)
    {
        $input = $request->all();
        $userid = Auth::guard('api')->user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) === false) {
                    $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) === true) {
                    $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg, "data" => array());
            }
        }
        return Response::json($arr);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deafpass(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|string',
                'password' => 'required|string|min:6',
            ]
        );
        if ($validator->fails()) {
            return $this->sendError('Validator Error', $validator->errors());
        }
        //$user = $this->checkAuth($request);
        //if ($user === null) {
        // $success['added'] = false;
        // return $this->sendError('Fail to modify user.', $success);
        //}

//return $request->input('email');

        $user = User::where('email', $request->input('email'))->first();
        //return $user;

        if ($user != false) {
            // bcrypt($input['password']);
            $user->password = Hash::make($request->input('password'));//bcrypt($request->input('password'));
            $user->token = hash('sha256', Str::random(60));
            $user->save();
            //$success['modified'] = true;
            $success['id'] = $user->id;
            $success['token'] = $user->token;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            return $this->sendResponse($success, 'User modified successfully.');
        }
        //$success['modified'] = false;
        return $this->sendError('Fail to modify user.', "User not found");

    }
}

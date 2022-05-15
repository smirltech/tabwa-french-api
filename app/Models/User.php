<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'token', 'created_at', 'updated_at',
    ];

    public static function findAll($controller)
    {
        $users = User::orderBy('name', 'ASC')->get();
        return $controller->sendResponse($users, 'Users retrieved successfully.');
    }


    /*public function posts() {
     return $this->hasMany('App\Post');
    }*/

    public static function register($controller, Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'c_password' => 'required|string|min:6|same:password',
            ]
        );
        if ($validator->fails()) {
            return $controller->sendError('Validator Error', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);//bcrypt($input['password']);
        $input['token'] = hash('sha256', Str::random(256));
        try {
            $user = User::create($input);
            if ($user) {
                $success['id'] = $user->id;
                $success['token'] = $user->token;
                $success['name'] = $user->name;
                $success['email'] = $user->email;

                // notify Admin of the new user
                $details = [
                    'subject' => 'New registration',
                    'title' => 'New User registered successful',
                    'body' => "A new user has successfully registered. Name: ".$user->name.", email: ".$user->email.".",
                ];
                sendNormalMail(adminEmail(), $details);

                return $controller->sendResponse($success, 'User register successfully.');
            }
            $controller->sendError('Error', 'User register failed.');
        } catch (\Exception $e) {
            return $controller->sendError('Error', "User exists already.");
        }

    }

    public static function login($controller, Request $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $usr = Auth::user();
            $user = User::find($usr->id);
            $user->token = hash('sha256', Str::random(256));
            $user->save();
            $success['id'] = $user->id;
            $success['token'] = $user->token;
            $success['name'] = $user->name;
            $success['email'] = $user->email;

            // notify Admin of the new user
            $details = [
                'subject' => 'User Login',
                'title' => 'User login successful',
                'body' => "A user has successfully logged in. Name: ".$user->name.", email: ".$user->email.".",
            ];
            sendNormalMail(adminEmail(), $details);
            return $controller->sendResponse($success, 'User login successfully !');
        }
        return $controller->sendError('Login Error', []);
    }

    public static function isLogin($controller, Request $request)
    {
        $id = $request->input('id');
        $token = $request->input('token');
        $user = User::where(['token' => $token])->find($id);
        if ($user !== null) {
            $success['login'] = true;
            return $controller->sendResponse($success, 'User is logged in.');
        }
        $success['login'] = false;
        return $controller->sendError('User is logged out.', $success);
    }

    public function words()
    {
        return $this->hasMany(Word::class);
    }
}

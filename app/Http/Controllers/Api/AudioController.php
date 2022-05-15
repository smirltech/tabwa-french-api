<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AudioController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function upload(Request $request)
    {
        /*  $user = $this->checkAuth($request);
          if ($user === null) {
              $success['added'] = false;
              return $this->sendError('Fail to add audio.', $success);
          }*/
        $extensions = ['mpga', 'wav', 'ogg', 'flac', 'aac', 'm4a', 'wma', 'mid', 'midi', 'wav', 'aiff', 'au', 'amr'];
        $validated = Validator::make($request->all(), [
            'audio' => 'required|file'
        ]);
        if ($validated->fails()) {
            $success['added'] = false;
            $success['message'] = $validated->errors();
            return $this->sendError('Fail validation when adding audio.', $success);
        }

        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $audioName = $audio->getClientOriginalName();
            $extension = $audio->getClientOriginalExtension();
            if (!in_array($extension, $extensions)) {
                $success['added'] = false;
                return $this->sendError('Fail to add audio. File is not of audio type.', $success);
            }
            $section = $request->input('section');
            $section_id = $request->input('section_id');
            $audio->move(public_path("audio/$section"), $section_id . '.' . $extension);
            $audioPath = url("audio/$section/" . $section_id . '.' . $extension);
            // return $audioPath;

            $success['added'] = true;
            $success['message'] = $audioPath;
            return $this->sendResponse('Audio uploaded successfully !', $success);
        }
        $success['added'] = false;
        return $this->sendError('Fail to add audio. Audio file was not included.', $success);


     // return "this is it";
    }

    private function checkAuth(Request $request)
    {
        $token = $request->bearerToken();
        return User::where('token', $token)->first();
    }
}

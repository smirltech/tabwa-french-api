<?php

namespace App\Http\Controllers\Api;

use App\Models\Translation;
use App\Models\User;
use App\Models\Word;
use Illuminate\Http\Request;

class LexicsController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Word::findAll($this);
    }

    public function show(Request $request, $id)
    {
        $user = $this->checkAuth($request);
        if ($user === null) {
            $success['edited'] = false;
            return $this->sendError('Fail to modify word.', $success);
        }

        return Word::findWord($this, $id);
    }

    private function checkAuth(Request $request)
    {
        $token = $request->bearerToken();
        return User::where('token', $token)->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->checkAuth($request);
        if ($user === null) {
            $success['added'] = false;
            return $this->sendError('Fail to add word.', $success);
        }

        $word = Word::addWord($this, $request, $user->id);
        return $word;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request)
    {
        $user = $this->checkAuth($request);
        if ($user === null) {
            $success['added'] = false;
            return $this->sendError('Fail to add word.', $success);
        }

        $word = new Word();
        $word->word = $request->input('word');
        $word->categorie = $request->input('categorie');
        $word->user_id = $user->id;//$request->input('user_id');
        $word->updater_id = $user->id;

        $did = $word->save();

        if ($did) {
            $translation = new Translation();
            $translation->word_id = $word->id;
            $translation->type_id = $request->input('type_id');
            $translation->translation = $request->input('translation');
            $translation->example = $request->input('example');
            $translation->example_translation = $request->input('example_translation');
            $translation->user_id = $user->id;
            $translation->updater_id = $user->id;

            $did2 = $translation->save();
        }

        if ($did === true) {
            $success['added'] = true;
            return $this->sendResponse($success, 'Word added successfully.');
        }
        $success['added'] = false;
        return $this->sendError('Fail to add word.', $success);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->checkAuth($request);
        if ($user === null) {
            $success['edited'] = false;
            return $this->sendError('Fail to modify word.', $success);
        }

        $word = Word::editWord($this, $request, $id, $user->id);
        return $word;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

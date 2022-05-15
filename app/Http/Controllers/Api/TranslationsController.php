<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;

use App\Models\Translation;
use App\Models\User;
use Illuminate\Http\Request;

class TranslationsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            return $this->sendError('Fail to add Translation.', $success);
        }

        return Translation::addTranslation($this, $request, $user->id);

    }

    private function checkAuth(Request $request)
    {
        $token = $request->bearerToken();
        return User::where('token', $token)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $success['added'] = false;
            return $this->sendError('Fail to modify Translation.', $success);
        }

        return Translation::editTranslation($this, $request,$id, $user->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $translation = Translation::find($id);
        $tmp = $translation->translation;
        $translation->delete();
        return redirect()->back()->with('success', "Traduction \" $tmp \" supprimée avec succès !");
    }
}

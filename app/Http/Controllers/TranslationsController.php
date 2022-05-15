<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TranslationsController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     $this->validate($request, [
       'translation' => 'required'
     ]);
     $translation = new Translation();
     $translation->word_id = $request->input('word_id');
     $translation->type_id = $request->input('type_id');
     $translation->translation = $request->input('translation');
     $translation->example = $request->input('example');
     $translation->example_translation = $request->input('example_translation');

     $translation->save();
     return redirect()->back()->with('success', "Traduction créée avec succès !");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     $this->validate($request, [
       'translation' => 'required'
     ]);
     $translation = Translation::find($id);
     $translation->type_id = $request->input('type_id');
     $translation->translation = $request->input('translation');
     $translation->example = $request->input('example');
     $translation->example_translation = $request->input('example_translation');

     $translation->save();
     return redirect()->back()->with('success', "Traduction modifiée avec succès !");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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

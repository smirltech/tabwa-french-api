<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TypesController extends Controller
{

 /**
  * Create a new controller instance.
  *
  * @return void
  */
 public function __construct() {
  $this->middleware('auth');
 }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $data['types'] = Type::orderBy('type', 'ASC')->paginate(10);

     // $data['posts'] = Post::orderBy('title', 'DESC')->get();

     $data['ma'] = 2;
     return view('types.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     $data['title'] = 'Create Type';
     $data['ma'] = 2;
     return view('types.create')->with($data);
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
       'type' => 'required',
       'abbrev' => 'required'
     ]);
     $type = new Type();
     $type->type = $request->input('type');
     $type->abbrev = $request->input('abbrev');

     $type->save();
     return redirect('types')->with('success', "Type $type->type créé avec succès !");

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
     $type = Type::find($id);
     if($type === null){
      return redirect('types')->with('error', "Type de ID $id n'est pas trouvé dans la base des données !");
     }
     $data['type'] = $type;
     $data['title'] = 'Edit Type';
     $data['ma'] = 2;
     return view('types.edit')->with($data);
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
       'type' => 'required',
       'abbrev' => 'required'
     ]);
     $type = Type::find($id);
     $tmp = $type->type;
     $type->type = $request->input('type');
     $type->abbrev = $request->input('abbrev');

     $type->save();
     return redirect('types')->with('success', "Type $tmp modifié avec succès !");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     $type = Type::find($id);
     $tmp = $type->type;
     $type->delete();
     return redirect()->back()->with('success', "Type $tmp supprimé avec succès !");
    }
}

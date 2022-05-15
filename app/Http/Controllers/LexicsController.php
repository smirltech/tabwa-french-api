<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LexicsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $data['lexics'] = Word::orderBy('word', 'ASC')->paginate(10);

        // $data['posts'] = Post::orderBy('title', 'DESC')->get();
        //$data['lexics'] = $user->words()->paginate(10);
        $data['my_lexics'] = $user->words;
        $data['ma'] = 1;
        //echo $data['my_lexics'];
        return view('lexics.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Create Mot';
        $data['ma'] = 1;
        return view('lexics.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'word' => 'required',
            'categorie' => 'required'
        ]);
        $word = new Word();
        $word->word = $request->input('word');
        $word->categorie = $request->input('categorie');
        $word->user_id = auth()->user()->id;

        $word->save();
        return redirect('lexics')->with('success', "Mot $word->word créé avec succès !");

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
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function edit($id)
    {
        $lexic = Word::find($id);
        if ($lexic === null) {
            return redirect('lexics')->with('error', "Mot de ID $id n'est pas trouvé dans la base des données !");
        }
        $data['lexic'] = $lexic;
        $data['ma'] = 1;
        $data['translations'] = $lexic->translations;
        $_types = Type::all();
        $data['types'] = array();
        foreach ($_types as $t) {
            $data['types'][$t->id] = $t->type;
        }
        // echo json_encode($data['types']);
        return view('lexics.edit')->with($data);
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
        $this->validate($request, [
            'word' => 'required',
            'categorie' => 'required'
        ]);
        $lexic = Word::find($id);
        $tmp = $lexic->word;
        $lexic->word = $request->input('word');
        $lexic->categorie = $request->input('categorie');

        $lexic->save();
        return redirect('lexics')->with('success', "Mot $tmp modifié avec succès !");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lexic = Word::find($id);
        $tmp = $lexic->word;
        $lexic->delete();
        return redirect()->back()->with('success', "Mot $tmp supprimé avec succès !");
    }
}

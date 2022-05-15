<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class Word extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'word',
        'categorie',
        'user_id',
        'updater_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //  'password', 'remember_token', 'token', 'created_at', 'updated_at',
    ];


    public static function findAll($controller)
    {
        $words = Word::with('user', 'updater', 'translations', 'translations.user', 'translations.updater', 'translations.type')->orderBy('word', 'ASC')->get();
        return $controller->sendResponse($words, 'Words retrieved successfully.');
    }

    public static function findWord($controller, $id)
    {
        $word = Word::with('user', 'updater', 'translations', 'translations.user', 'translations.updater', 'translations.type')->orderBy('word', 'ASC')->find($id);
        return $controller->sendResponse($word, 'Word retrieved successfully.');
    }

    public static function addWord($controller, Request $request, $user_id)
    {
        try {
            $word = Word::create([
                'user_id' => $user_id,
                'updater_id' => $user_id,
                'word' => $request->input('word'),
                'categorie' => $request->input('categorie'),
            ]);

            try {
                Translation::create([
                    'word_id' => $word->id,
                    'type_id' => $request->input('type_id'),
                    'translation' => $request->input('translation'),
                    'example' => $request->input('example'),
                    'example_translation' => $request->input('example_translation'),
                    'user_id' => $user_id,
                    'updater_id' => $user_id,
                ]);

            } catch (\Exception $a) {
            }

            if ($word !== null) {
                $success['word'] = $word;
                return $controller->sendResponse($success, 'Word added successfully.');
            }
        } catch (\Exception $e) {
            $success['code'] = 500;
            return $controller->sendError('Ce mot existe déjà', null, 500);
        }
        $success['added'] = false;
        return $controller->sendError('Fail to add word.', $success);
    }

    public static function editWord($controller, Request $request, $id, $user_id)
    {

        //$id = $request->input('id');
        $word = Word::find($id);
        $word->word = $request->input('word');
        $word->categorie = $request->input('categorie');
        $word->updater_id = $user_id;

        try {
            $did = $word->save();

            if ($did === true) {
                $success['word'] = $word;
                return $controller->sendResponse($success, 'Word modified successfully.');
            }
        } catch (\Exception $e) {
            $success['code'] = 500;
            return $controller->sendError('Ce mot existe déjà', null, 500);
        }

        $success['edited'] = false;
        return $controller->sendError('Fail to modify word.', $success);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function updater()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
    /*public function translationTypes() {
     //return $this->hasManyThrough('App\Type', 'App\Translation', 'word_id', 'id', 'id', 'id');
     return $this->hasOneThrough('App\Type','App\Translation', 'id',
       'id', 'id', 'id');
    }*/
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Translation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'word_id',
        'type_id',
        'translation',
        'example',
        'example_translation',
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
        $translations = Translation::with('user', 'updater', 'translations', 'translations.user', 'translations.updater', 'translations.type')->orderBy('translation', 'ASC')->get();
        return $controller->sendResponse($translations, 'Translations retrieved successfully.');
    }

    public static function findWord($controller, $id)
    {
        $translation = Translation::with('user', 'updater', 'translations', 'translations.user', 'translations.updater', 'translations.type')->orderBy('translation', 'ASC')->find($id);
        return $controller->sendResponse($translation, 'Translation retrieved successfully.');
    }

    public static function addTranslation($controller, Request $request, $user_id)
    {
        $translation = Translation::create([
            'word_id' => $request->input('word_id'),
            'type_id' => $request->input('type_id'),
            'translation' => $request->input('translation'),
            'example' => $request->input('example'),
            'example_translation' => $request->input('example_translation'),
            'user_id' => $user_id,
            'updater_id' => $user_id,
        ]);

        if ($translation !== null) {
            return $controller->sendResponse($translation, 'Translation added successfully.');
        }
        $success['added'] = false;
        return $controller->sendError('Fail to add Translation.', $success);
    }

    public static function editTranslation($controller, Request $request, $id, $user_id)
    {
       // $id = $request->input('id');
        $translation = Translation::find($id);
        $translation->type_id = $request->input('type_id');
        $translation->translation = $request->input('translation');
        $translation->example = $request->input('example');
        $translation->example_translation = $request->input('example_translation');
        $translation->updater_id = $request->input('user_id');

        $did = $translation->save();

        if ($did === true) {

            return $controller->sendResponse($translation, 'Translation modified successfully.');
        }
        $success['added'] = false;
        return $controller->sendError('Fail to modify translation.', $success);
    }

    public function word()
    {
        return $this->belongsTo(Word::class)->withDefault();
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}

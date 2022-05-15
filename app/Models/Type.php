<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public static function findAll($controller)
    {
        $types = Type::orderBy('type', 'ASC')->get();
        return $controller->sendResponse($types, 'Words retrieved successfully.');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
}

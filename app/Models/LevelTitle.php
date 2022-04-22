<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelTitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_nivel'
    ];

    // * Relacion uno a muchos
    public function jobTitles()
    {
        return $this->hasMany('App\Models\JobTitle');
    }
}

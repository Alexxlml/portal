<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_titles_id',
        'nombre_puesto'
    ];

    // * Relacion uno a muchos
    public function collaborators()
    {
        return $this->hasMany('App\Models\Collaborator');
    }

    //* Relacion muchos a uno
    public function levels()
    {
        return $this->belongsTo('App\Models\LevelTitle');
    }
}

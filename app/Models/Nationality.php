<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'pais',
        'gentilicio'
    ];

    // * Relacion uno a muchos
    public function collaborators()
    {
        return $this->hasMany('App\Models\Collaborator');
    }
}

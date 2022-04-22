<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_estado'
    ];

    // * Relacion uno a muchos
    public function collaborators()
    {
        return $this->hasMany('App\Models\Collaborator');
    }
}

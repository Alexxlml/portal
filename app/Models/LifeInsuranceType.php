<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LifeInsuranceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_seguro'
    ];

    // * Relacion uno a muchos
    public function collaborators()
    {
        return $this->hasMany('App\Models\Collaborator');
    }
}

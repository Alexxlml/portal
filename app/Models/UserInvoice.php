<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborator_id',
        'no_quincena',
        'ruta_pdf',
        'ruta_xml',
        'comentarios',
    ];



    //* Relacion muchos a uno
    public function collaborators()
    {
        return $this->belongsTo('App\Models\Collaborator');
    }
}

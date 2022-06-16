<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborators_id',
        'no_quincena',
        'ruta_pdf',
        'ruta_xml',
        'monto_total',
        'moneda',
        'fecha_timbrado',
        'comentarios',
    ];



    //* Relacion muchos a uno
    public function collaborators()
    {
        return $this->belongsTo('App\Models\Collaborator');
    }
}

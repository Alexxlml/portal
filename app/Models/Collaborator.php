<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_colaborador',
        'assigned_offices_id',
        'nombre_1',
        'nombre_2',
        'ap_paterno',
        'ap_materno',
        'fecha_nacimiento',
        'genders_id',
        'marital_statuses_id',
        'curp',
        'rfc',
        'life_insurance_types',
        'no_seguro_social',
        'no_pasaporte',
        'no_visa_americana',
        'domicilio',
        'colonia',
        'municipio',
        'estado',
        'nationalities_id',
        'codigo_postal',
        'job_titles_id',
        'work_areas_id',
        'correo',
        'work_employment_contract_types_id',
        'fecha_ingreso',
        'estado_colaborador',
        'foto',
    ];
    

    // * Relacion uno a muchos

    // * Contenido Arriba

    //* Relacion muchos a uno
    public function assignedOffices()
    {
        return $this->belongsTo('App\Models\AssignedOffice');
    }

    public function genders()
    {
        return $this->belongsTo('App\Models\Genders');
    }

    public function maritalStatuses()
    {
        return $this->belongsTo('App\Models\MaritalStatus');
    }

    public function lifeInsuranceTypes()
    {
        return $this->belongsTo('App\Models\LifeInsuranceType');
    }

    public function nationalities()
    {
        return $this->belongsTo('App\Models\Nationality');
    }

    public function jobTitles()
    {
        return $this->belongsTo('App\Models\JobTitle');
    }

    public function workAreas()
    {
        return $this->belongsTo('App\Models\WorkArea');
    }

    public function employmentContractTypes()
    {
        return $this->belongsTo('App\Models\EmploymentContractType');
    }
}

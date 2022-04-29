<?php

namespace App\Http\Livewire\Formularios;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\JobTitle;
use App\Models\WorkArea;
use App\Models\Nationality;
use App\Models\Collaborator;
use Livewire\WithFileUploads;
use App\Models\AssignedOffice;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EdicionColaborador extends Component
{
    // ? Uso de clase WithFileUploads para la subida de archivos
    // ? Uso de clase LivewireAlert para las notificaciones y mensajes de confirmacion
    use WithFileUploads, LivewireAlert;


    // ? Declaracion de variables formulario
    public $colaborador, $oficina_asignada, $nombre_1, $nombre_2, $ap_paterno, $ap_materno,
        $fecha_nacimiento, $genero, $estado_civil, $curp, $rfc, $tipo_seguro, $no_seguro_social = '',
        $no_pasaporte = '', $no_visa = '', $domicilio, $colonia, $municipio, $estado, $nacionalidad,
        $codigo_postal, $paternidad, $puesto, $area, $correo, $tipo_contrato, $fecha_ingreso, $foto, $foto_ruta, $antiquity;

    // ? Función que recibe el ID del colaborador y carga el código antes de la renderización de la vista
    public function mount($id)
    {
        // ? Consulta de la información del colaborador
        $this->colaborador = Collaborator::find($id);

        // ? Asignación de valores del colaborador a cada una de las diferentes variables del formulario
        $this->oficina_asignada = $this->colaborador->assigned_offices_id;
        $this->nombre_1 = $this->colaborador->nombre_1;
        $this->nombre_2 = $this->colaborador->nombre_2;
        $this->ap_paterno = $this->colaborador->ap_paterno;
        $this->ap_materno = $this->colaborador->ap_materno;
        $this->fecha_nacimiento = $this->colaborador->fecha_nacimiento;
        $this->genero = $this->colaborador->genders_id;
        $this->estado_civil = $this->colaborador->marital_statuses_id;
        $this->curp = $this->colaborador->curp;
        $this->rfc = $this->colaborador->rfc;
        $this->tipo_seguro = $this->colaborador->life_insurance_types_id;
        $this->no_seguro_social = $this->colaborador->no_seguro_social;
        $this->no_pasaporte = $this->colaborador->no_pasaporte;
        $this->no_visa = $this->colaborador->no_visa_americana;
        $this->domicilio = $this->colaborador->domicilio;
        $this->colonia = $this->colaborador->colonia;
        $this->municipio = $this->colaborador->municipio;
        $this->estado = $this->colaborador->estado;
        $this->nacionalidad = $this->colaborador->nationalities_id;
        $this->codigo_postal = $this->colaborador->codigo_postal;
        $this->paternidad = $this->colaborador->paternidad;
        $this->puesto = $this->colaborador->job_titles_id;
        $this->area = $this->colaborador->work_areas_id;
        $this->correo = $this->colaborador->correo;
        $this->tipo_contrato = $this->colaborador->employment_contract_types_id;
        $this->fecha_ingreso = $this->colaborador->fecha_ingreso;
        $this->antiquity = Carbon::parse($this->fecha_ingreso)->shortAbsoluteDiffForHumans(Carbon::now());
    }

    // ? Funcion que renderiza la vista y las variables que consultan informacion de la base de datos
    public function render()
    {
        // *  Carga de informacion
        $nacionalidades = Nationality::all();
        $oficinas = AssignedOffice::all();
        $areas = WorkArea::all();
        $puestos = JobTitle::join('level_titles', 'job_titles.level_titles_id', 'level_titles.id')
            ->selectRaw('job_titles.id, CONCAT_WS(" ", level_titles.nombre_nivel, job_titles.nombre_puesto) AS puesto_completo')
            ->get();

        return view('livewire.formularios.edicion-colaborador', compact(
            'nacionalidades',
            'oficinas',
            'areas',
            'puestos'
        ));
    }

    // ? Función para descargar la imagen del colaborador
    public function downloadImage()
    {
        return Storage::disk('public')->download($this->colaborador->foto);
    }
}

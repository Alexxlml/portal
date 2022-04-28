<?php

namespace App\Http\Livewire\Formularios;

use App\Models\AssignedOffice;
use App\Models\JobTitle;
use App\Models\Nationality;
use App\Models\WorkArea;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegistroColaborador extends Component
{
    // ? Uso de clase WithFileUploads para la subida de archivos
    use WithFileUploads;

    // ? Declaracion de variables formulario
    public $no_colaborador, $oficina_asignada, $nombre_1, $nombre_2, $ap_paterno, $ap_materno,
        $fecha_nacimiento, $genero, $estado_civil, $curp, $rfc, $tipo_seguro, $no_seguro,
        $no_pasaporte, $no_visa, $domicilio, $colonia, $municipio, $estado, $nacionalidad,
        $codigo_postal, $paternidad, $puesto, $area, $correo, $tipo_contrato, $fecha_ingreso, $foto;

    // ? Variables de radio button
    // * Genero
    public $genero_masculino, $genero_femenino, $genero_no_binario;
    // * Estado Civil
    public $estado_civil_soltero, $estado_civil_casado, $estado_civil_union_libre;
    // * Paternidad
    public $paternidad_si, $paternidad_no;
    // * Tipo Seguro
    public $tipo_seguro_sgm, $tipo_seguro_imss;
    // * Tipo Contrato
    public $tipo_contrato_honorarios;

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

        return view('livewire.formularios.registro-colaborador', compact(
            'nacionalidades',
            'oficinas',
            'areas',
            'puestos'
        ));
    }

    // ? Funciones que escuchan los cambios en las variables de radio button y asignan el resultado en variables generales
    // * Genero
    public function updatedGeneroMasculino()
    {
        $this->genero_masculino ? $this->genero = 1 : "";
    }
    public function updatedGeneroFemenino()
    {
        $this->genero_femenino ? $this->genero = 2 : "";
    }
    public function updatedGeneroNoBinario()
    {
        $this->genero_no_binario ? $this->genero = 3 : "";
    }

    // * Estado Civil
    public function updatedEstadoCivilSoltero()
    {
        $this->estado_civil_soltero ? $this->estado_civil = 1 : "";
    }
    public function updatedEstadoCivilCasado()
    {
        $this->estado_civil_casado ? $this->estado_civil = 2 : "";
    }
    public function updatedEstadoCivilUnionLibre()
    {
        $this->estado_civil_union_libre ? $this->estado_civil = 3 : "";
    }

    // * Paternidad
    public function updatedPaternidadSi()
    {
        $this->paternidad_si ? $this->paternidad = 1 : "";
    }
    public function updatedPaternidadNo()
    {
        $this->paternidad_no ? $this->paternidad = 0 : "";
    }

    // * Tipo Seguro
    public function updatedTipoSeguroSgm()
    {
        $this->tipo_seguro_sgm ? $this->tipo_seguro = 1 : "";
    }
    public function updatedTipoSeguroImss()
    {
        $this->tipo_seguro_imss ? $this->tipo_seguro = 2 : "";
    }

    // * Tipo Contrato
    public function updatedTipoContratoHonorarios(){
        $this->tipo_contrato_honorarios ? $this->tipo_contrato = 1 : "";
    }
}

<?php

namespace App\Http\Livewire\Formularios;

use Livewire\Component;
use Livewire\WithFileUploads;

class RegistroColaborador extends Component
{
    // ? Uso de clase WithFileUploads para la subida de archivos
    use WithFileUploads;

    // ? Declaracion de variables
    public $no_colaborador, $oficina, $nombre_1, $nombre_2, $ap_paterno, $ap_materno, 
            $fecha_nacimiento, $genero, $estado_civil, $curp, $rfc, $tipo_seguro, $no_seguro,
            $no_pasaporte, $no_visa, $domicilio, $colonia, $municipio, $estado, $nacionalidad, 
            $codigo_postal, $paternidad, $puesto, $area, $correo, $tipo_contrato, $fecha_ingreso,$foto;

    public function render()
    {
        return view('livewire.formularios.registro-colaborador');
    }
}

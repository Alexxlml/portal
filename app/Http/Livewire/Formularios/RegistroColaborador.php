<?php

namespace App\Http\Livewire\Formularios;

use Exception;
use Livewire\Component;
use App\Models\JobTitle;
use App\Models\WorkArea;
use App\Models\Nationality;
use App\Models\Collaborator;
use Livewire\WithFileUploads;
use App\Models\AssignedOffice;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RegistroColaborador extends Component
{
    // ? Uso de clase WithFileUploads para la subida de archivos
    // ? Uso de clase LivewireAlert para las notificaciones y mensajes de confirmacion
    use WithFileUploads, LivewireAlert;

    // ? Declaracion de variables formulario
    public $no_colaborador, $oficina_asignada, $nombre_1, $nombre_2, $ap_paterno, $ap_materno,
        $fecha_nacimiento, $genero, $estado_civil, $curp, $rfc, $tipo_seguro = 0, $no_seguro = '',
        $no_pasaporte = '', $no_visa = '', $domicilio, $colonia, $municipio, $estado, $nacionalidad,
        $codigo_postal, $paternidad, $puesto, $area, $correo, $tipo_contrato, $fecha_ingreso, $foto, $foto_ruta;

    // ? Inicio Alertas
    public function getListeners()
    {
        return [
            'registrar',
            'cancelar'
        ];
    }

    // ? Funcion que arroja un cuadro de confirmacion y redirige a ciertas funciones 
    // ? dependiendo el boton que se presione
    public function triggerConfirm()
    {
        $this->confirm('¿Quieres realizar este registro?', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'registrar',
            'showCancelButton' => true,
            'onDismissed' => 'cancelar',
            'cancelButtonText' => 'No',
            'confirmButtonText' => 'Si',
        ]);
    }
    // ? Funcion que arroja una alerta en caso de que se haga clic en el boton denied o NO
    public function cancelar()
    {
        $this->alert('info', 'Se canceló el registro', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
            'showConfirmButton' => false,
            'onConfirmed' => '',
            'showCancelButton' => false,
            'onDismissed' => '',
            'cancelButtonText' => 'No',
            'confirmButtonText' => 'Si',
            'text' => '',
        ]);
    }
    // ? Fin Alertas

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

    // ? Funcion de registro del colaborador (Se ejecuta cuando se confirma el guardado de informacion)

    public function registrar()
    {
        /* $this->validate(); */
        try {

            // ? Se guarda en la variable no_colaborador el numero generado por la funcion generadora
            $this->no_colaborador = $this->generadorNoColaborador();

            // ? Guardado y extraccion de la foto del colaborador
            $this->foto_ruta = $this->foto->storeAS('/public/images', $this->no_colaborador . ".jpg");
             
            DB::transaction(
                function () {
                    Collaborator::create([
                        'no_colaborador' => $this->no_colaborador,
                        'assigned_offices_id' => $this->oficina_asignada,
                        'nombre_1' => $this->nombre_1,
                        'nombre_2' => $this->nombre_2,
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'fecha_nacimiento' => $this->fecha_nacimiento,
                        'genders_id' => $this->genero,
                        'marital_statuses_id' => $this->estado_civil,
                        'curp' => $this->curp,
                        'rfc' => $this->rfc,
                        'life_insurance_types_id' => $this->tipo_seguro,
                        'no_seguro_social' => $this->no_seguro,
                        'no_pasaporte' => $this->no_pasaporte,
                        'no_visa_americana' => $this->no_visa,
                        'domicilio' => $this->domicilio,
                        'colonia' => $this->colonia,
                        'municipio' => $this->municipio,
                        'estado' => $this->estado,
                        'nationalities_id' => $this->nacionalidad,
                        'codigo_postal' => $this->codigo_postal,
                        'paternidad' => $this->paternidad,
                        'job_titles_id' => $this->puesto,
                        'work_areas_id' => $this->area,
                        'correo' => $this->correo,
                        'employment_contract_types_id' => $this->tipo_contrato,
                        'fecha_ingreso' => $this->fecha_ingreso,
                        'estado_colaborador' => 1,
                        'foto' => $this->foto_ruta,
                    ]);
                }
            );

            $this->flash(
                'success',
                'El colaborador ha sido registrado con éxito',
                [
                    'position' =>  'top-end',
                    'timer' =>  4000,
                    'timerProgressBar' => true,
                    'toast' =>  true,
                    'text' =>  '',
                    'confirmButtonText' =>  'Ok',
                    'cancelButtonText' =>  'Cancel',
                    'showCancelButton' =>  false,
                    'showConfirmButton' =>  false,
                ]
            );

            return redirect()->route('registro-colaborador');
        } catch (Exception $ex) {
            $this->alert('error', 'Este colaborador ya ha sido registrado', [
                'position' => 'top-end',
                'timer' => '3000',
                'toast' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
                'showCancelButton' => false,
                'onDismissed' => '',
                'cancelButtonText' => 'No',
                'confirmButtonText' => 'Si',
                'timerProgressBar' => true,
            ]);
        }
    }

    // ? Generador de numero de colaborador de acuerdo al ultimo registro de la base de datos
    public function generadorNoColaborador()
    {
        // * Numero de digitos que tendrá después del prefix
        $length = 4;
        // * Prefijo por defecto del numero de colaborador
        $prefix = 'SC';
        // * Consulta el ultimo colaborador registrado
        $data = Collaborator::orderBy('id', 'desc')->first();

        // * Condicion para revisar si existe un colaborador registrado
        if (!$data) {
            // * En caso de que no exista el primero numero sera SC0001 por defecto
            $og_length = 3;
            $last_number = 1;
        } else {
            $code = substr($data->no_colaborador, strlen($prefix) + 1);
            $actual_last_number = ($code / 1) * 1;
            $increment_last_number = $actual_last_number + 1;
            $last_number_length = strlen($increment_last_number);
            $og_length = $length - $last_number_length;
            $last_number = $increment_last_number;
        }
        // * Se añaden la cantidad de ceros antes del numero consecuente
        $zeros = "";
        for ($i = 0; $i < $og_length; $i++) {
            $zeros .= "0";
        }
        // * Retorna una cadena con el prefijo, la cantidad de ceros y el numero que sigue del ultimo registrado
        return $prefix . $zeros . $last_number;
    }
}

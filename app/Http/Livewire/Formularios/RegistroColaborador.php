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
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RegistroColaborador extends Component
{
    // ? Uso de clase WithFileUploads para la subida de archivos
    // ? Uso de clase LivewireAlert para las notificaciones y mensajes de confirmacion
    use WithFileUploads, LivewireAlert;

    // ? Declaracion de variables formulario
    public $no_colaborador, $oficina_asignada, $nombre_1, $nombre_2, $ap_paterno, $ap_materno,
        $fecha_nacimiento, $genero, $estado_civil, $curp, $rfc, $tipo_seguro, $no_seguro_social = '',
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

    // ? Declaración de Reglas de validación para campos del formulario
    protected $rules = [
        'nombre_1' => 'required|max:50|regex:/^([a-zA-ZùÙüÜäàáëèéïìíöòóüùúÄÀÁËÈÉÏÌÍÖÒÓÜÚñÑ\s]+)$/',
        'nombre_2' => 'max:50',
        'ap_paterno' => 'required|max:50|regex:/^([a-zA-ZùÙüÜäàáëèéïìíöòóüùúÄÀÁËÈÉÏÌÍÖÒÓÜÚñÑ\s]+)$/',
        'ap_materno' => 'max:50',
        'fecha_nacimiento' => 'required',
        'genero' => 'required',
        'estado_civil' => 'required',
        'paternidad' => 'required',
        'curp' => 'required|max:18|regex:/[A-Z0-9]/',
        'rfc' => 'required|max:15|regex:/[A-Z0-9]/',
        'tipo_seguro' => 'required',
        'no_seguro_social' => 'max:15|regex:/[A-Z0-9]/',
        'no_pasaporte' => 'max:10|regex:/[A-Z0-9]/',
        'no_visa' => 'max:8|regex:/[A-Z0-9]/',
        'domicilio' => 'required',
        'colonia' => 'required',
        'municipio' => 'required|regex:/[a-zA-Z]/',
        'estado' => 'required|regex:/[a-zA-Z]/',
        'codigo_postal' => 'required|regex:/^[0-9]{5}$/',
        'nacionalidad' => 'required',
        'oficina_asignada' => 'required',
        'area' => 'required',
        'correo' => 'required|email',
        'puesto' => 'required',
        'tipo_contrato' => 'required',
        'fecha_ingreso' => 'required',
        'foto' => 'required',
    ];

    // ? Mensajes personalizados para validaciones
    protected $messages = [
        'nombre_1.required' => 'Este campo es obligatorio',
        'nombre_1.max' => 'Máximo 50 caracteres',
        'nombre_1.regex' => 'Este campo solo debe contener letras y espacios',
        'nombre_2.max' => 'Máximo 50 caracteres',
        'ap_paterno.required' => 'Este campo es obligatorio',
        'ap_paterno.max' => 'Máximo 50 caracteres',
        'ap_paterno.regex' => 'Este campo solo debe contener letras y espacios',
        'ap_materno.max' => 'Máximo 50 caracteres',
        'fecha_nacimiento.required' => 'Esta campo es obligatorio',
        'genero.required' => 'Elige una de las opciones',
        'estado_civil.required' => 'Elige una de las opciones',
        'paternidad.required' => 'Elige una de las opciones',
        'curp.required' => 'Este campo es obligatorio',
        'curp.max' => 'Máximo 18 caracteres',
        'curp.regex' => 'Este campo solo puede contener letras y números',
        'rfc.required' => 'Este campo es obligatorio',
        'rfc.max' => 'Máximo 15 caracteres',
        'rfc.regex' => 'Este campo solo puede contener letras y números',
        'tipo_seguro.required' => 'Elige una de las opciones',
        'no_seguro_social.max' => 'Máximo 15 caracteres',
        'no_seguro_social.regex' => 'Este campo solo puede contener letras y números',
        'no_pasaporte.max' => 'Máximo 10 caracteres',
        'no_pasaporte.regex' => 'Este campo solo puede contener letras y números',
        'no_visa.max' => 'Máximo 8 caracteres',
        'no_visa.regex' => 'Este campo solo puede contener letras y números',
        'domicilio.required' => 'Este campo es obligatorio',
        'colonia.required' => 'Este campo no puede estar vacía',
        'municipio.required' => 'Este campo es obligatorio',
        'municipio.regex' => 'Este campo solo puede contener letras mayúsculas y minúsculas',
        'estado.required' => 'Este campo es obligatorio',
        'estado.regex' => 'Este campo solo puede contener letras mayúsculas y minúsculas',
        'codigo_postal.required' => 'Este campo es obligatorio',
        'codigo_posta.regex' => 'Este campo solo puede contener 5 digitos',
        'nacionalidad.required' => 'Elige una de las opciones',
        'oficina_asignada.required' => 'Elige una de las opciones',
        'area.required' => 'Elige una de las opciones',
        'correo.required' => 'Este campo es obligatorio',
        'correo.email' => 'Este campo no tiene el formato correcto',
        'puesto.required' => 'Elige una de las opciones',
        'tipo_contrato.required' => 'Este campo es obligatorio',
        'fecha_ingreso.required' => 'Este campo es obligatorio',
        'foto.required' => 'Es necesario subir una fotografía',
    ];

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

        // * Restriccion de para que solo administradores puedan ver esta vista
        abort_if(Auth::user()->role_id == 2, 403, 'No tienes autorización para esta vista');
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
        $this->validate();
        try {

            // ? Se guarda en la variable no_colaborador el numero generado por la funcion generadora
            $this->no_colaborador = $this->generadorNoColaborador();

            // ? Guardado y extraccion de la foto del colaborador
            $extension = $this->foto->getClientOriginalExtension();
            $this->foto_ruta = $this->foto->storeAS('images', $this->no_colaborador . "." . $extension, 'public');

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
                        'no_seguro_social' => $this->no_seguro_social,
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

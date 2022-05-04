<?php

namespace App\Http\Livewire\Formularios;

use Exception;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\JobTitle;
use App\Models\WorkArea;
use App\Models\Nationality;
use App\Models\Collaborator;
use Livewire\WithFileUploads;
use App\Models\AssignedOffice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

    // ? Inicio Alertas
    public function getListeners()
    {
        return [
            'actualizar',
            'cancelar'
        ];
    }

    // ? Funcion que arroja un cuadro de confirmacion y redirige a ciertas funciones 
    // ? dependiendo el boton que se presione
    public function triggerConfirm()
    {
        $this->confirm('¿Quieres actualizar la información de este colaborador?', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'actualizar',
            'showCancelButton' => true,
            'onDismissed' => 'cancelar',
            'cancelButtonText' => 'No',
            'confirmButtonText' => 'Si',
        ]);
    }
    // ? Funcion que arroja una alerta en caso de que se haga clic en el boton denied o NO
    public function cancelar()
    {
        $this->alert(
            'info',
            'Se canceló la actualización',
            [
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
            ]
        );
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
    ];

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

        // * Restriccion de para que solo administradores puedan ver esta vista
        abort_if(Auth::user()->role_id == 2, 403, 'No tienes autorización para esta vista');
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

    public function actualizar()
    {
        // ? Actualizacion de fotografia

        if ($this->foto != null) {
            $this->validate([
                'foto' => 'required|image|max:1024'
            ]);
            try {

                Storage::delete('public/' . $this->colaborador->foto);

                DB::transaction(function () {

                    // ? Guardado y extraccion de la foto del colaborador
                    $extension = $this->foto->getClientOriginalExtension();
                    $this->foto_ruta = $this->foto->storeAS('images', $this->colaborador->no_colaborador . "." . $extension, 'public');

                    Collaborator::where('no_colaborador', $this->colaborador->no_colaborador)
                        ->update([
                            'foto' => $this->foto_ruta
                        ]);
                });
            } catch (Exception $ex) {
                dd($ex);
            }
        }

        $this->validate();
        try {

            DB::transaction(
                function () {
                    Collaborator::where('id', $this->colaborador->id)->update([
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
                    ]);
                }
            );

            $this->flash(
                'success',
                'Se ha actualizado con éxito',
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

            return redirect()->to('/edicion-colaborador/' . $this->colaborador->id);
        } catch (Exception $ex) {
            $this->alert('error', 'Ha ocurrido un error', [
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
}

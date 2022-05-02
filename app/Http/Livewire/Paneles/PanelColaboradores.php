<?php

namespace App\Http\Livewire\Paneles;

use Exception;
use Livewire\Component;
use App\Models\Collaborator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PanelColaboradores extends Component
{
    // ? Invocacion de la paginacion
    use WithPagination, LivewireAlert;

    // ? Declaracion de QueryString para los parametros
    // ? que pasan por la barra de navegacion
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage'
    ];

    // ? Declaracion de las variables que componen el queryString
    public $search, $perPage = '5';

    // ? Declaracion de variable para funcion de baja
    public $colaborador_id;

    // ? Inicio Alertas
    public function getListeners()
    {
        return [
            'alta',
            'baja',
            'cancelarBaja',
            'cancelarAlta',
        ];
    }

    // ? Funcion que arroja un cuadro de confirmacion y redirige a ciertas funciones 
    // ? dependiendo el boton que se presione
    public function triggerConfirm($id)
    {
        $this->confirm('¿Quieres dar de baja este colaborador?', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'baja',
            'inputAttributes' => $id,
            'showCancelButton' => true,
            'onDismissed' => 'cancelarBaja',
            'cancelButtonText' => 'No',
            'confirmButtonText' => 'Si',
        ]);
    }
    public function triggerConfirm2($id)
    {
        $this->confirm('¿Quieres dar de alta este colaborador?', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'alta',
            'inputAttributes' => $id,
            'showCancelButton' => true,
            'onDismissed' => 'cancelarBAlta',
            'cancelButtonText' => 'No',
            'confirmButtonText' => 'Si',
        ]);
    }
    // ? Funcion que arroja una alerta en caso de que se haga clic en el boton denied o NO
    public function cancelarBaja()
    {
        $this->alert(
            'info',
            'Se canceló la baja',
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

    public function cancelarAlta()
    {
        $this->alert(
            'info',
            'Se canceló la alta',
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

    // ? Funcion por defecto para renderizar el contenido de la vista
    public function render()
    {
        return view('livewire.paneles.panel-colaboradores', [
            'colaboradores' => DB::table('v_collaborators')
                ->where('no_colaborador', 'LIKE', "%{$this->search}%")
                ->orWhere('nombre_completo', 'LIKE', "%{$this->search}%")
                ->paginate($this->perPage)
        ]);
    }

    public function baja($data)
    {
        $this->colaborador_id = $data['data']['inputAttributes'];
        try {
            Collaborator::where('id', $this->colaborador_id)->update([
                'estado_colaborador' => 0,
            ]);

            $this->flash(
                'success',
                'Baja exitosa',
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
            return redirect()->to('/panel-colaboradores/');
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

    public function alta($data)
    {
        $this->colaborador_id = $data['data']['inputAttributes'];
        try {
            Collaborator::where('id', $this->colaborador_id)->update([
                'estado_colaborador' => 1,
            ]);

            $this->flash(
                'success',
                'Alta exitosa',
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
            return redirect()->to('/panel-colaboradores/');
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

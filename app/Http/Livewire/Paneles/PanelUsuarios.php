<?php

namespace App\Http\Livewire\Paneles;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class PanelUsuarios extends Component
{
    // ? Invocacion de la paginacion
    use WithPagination;

    // ? Declaracion de QueryString para los parametros
    // ? que pasan por la barra de navegacion
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage'
    ];

    // ? Declaracion de las variables que componen el queryString
    public $search, $perPage = '5';

    // ? Funcion por defecto para renderizar el contenido de la vista
    public function render()
    {
        return view('livewire.paneles.panel-usuarios', [
            'colaboradores' => DB::table('v_collaborators')
            ->where('no_colaborador', 'LIKE', "%{$this->search}%")
            ->orWhere('nombre_completo','LIKE', "%{$this->search}%")
            ->paginate($this->perPage)
        ]);
    }
}

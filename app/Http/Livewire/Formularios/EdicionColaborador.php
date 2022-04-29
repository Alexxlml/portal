<?php

namespace App\Http\Livewire\Formularios;

use App\Models\Collaborator;
use Livewire\Component;

class EdicionColaborador extends Component
{
    public $colaborador;

    public function mount($id){
        $this->colaborador = Collaborator::find($id);
    }

    public function render()
    {
        return view('livewire.formularios.edicion-colaborador');
    }
}

<?php

namespace App\Http\Livewire\Paneles;

use Livewire\Component;
use App\Models\UserInvoice;
use App\Models\Collaborator;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PanelFacturasUsuarios extends Component
{
    // ? Invocacion de la paginacion
    use WithPagination;

    // ? Declaracion de QueryString para los parametros
    // ? que pasan por la barra de navegacion
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage'
    ];

    // ? Declaracion de variables
    public $colaborador;

    // ? Funcion que revisa antes de mostrar la vista si el usuario esta registrado como colaborador
    public function mount()
    {
        $this->colaborador = Collaborator::where('correo', Auth::user()->email)->get();
        abort_if(count($this->colaborador) == 0, 403, 'No estás registrado aún, pide a un administrador que te registre como colaborador');
    }

    // ? Declaracion de las variables que componen el queryString
    public $search, $perPage = '5';

    public function render()
    {
        return view('livewire.paneles.panel-facturas-usuarios', [
            'facturas' => DB::table('v_user_invoices')
                ->where('collaborators_id', $this->colaborador[0]->id)
                ->orWhere('created_at', 'LIKE', "%{$this->search}%")
                ->paginate($this->perPage)
        ]);
    }

    // ? Funcion para descargar PDF y XML
    // ? Recibe 2 parametros del formulario que le indican el id de la factura y el tipo de archivo: 1 para PDF, 2 para XML
    public function descarga($id, $tipo)
    {
        $factura = UserInvoice::find($id);
        $tipo == 1 ? $ruta = $factura->ruta_pdf : $ruta = $factura->ruta_xml;
        return Storage::disk('public')->download($ruta);
    }
}

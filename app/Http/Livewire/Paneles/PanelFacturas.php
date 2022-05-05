<?php

namespace App\Http\Livewire\Paneles;

use Livewire\Component;
use App\Models\UserInvoice;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PanelFacturas extends Component
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

    public function render()
    {
        // * Restriccion de para que solo administradores puedan ver esta vista
        abort_if(Auth::user()->role_id == 2, 403, 'No tienes autorización para esta vista');
        return view('livewire.paneles.panel-facturas', [
            'facturas' => DB::table('v_user_invoices')
                ->where('nombre_completo', 'LIKE', "%{$this->search}%")
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

<?php

namespace App\Http\Livewire\Paneles;

use Exception;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\UserInvoice;
use App\Models\Collaborator;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PanelFacturasUsuarios extends Component
{
    // ? Invocacion de la paginacion
    use WithPagination, WithFileUploads, LivewireAlert;

    // ? Declaracion de QueryString para los parametros
    // ? que pasan por la barra de navegacion
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage'
    ];

    // ? Declaracion de variables
    public $colaborador, $f_pdf, $f_xml, $comentarios, $no_quincena, $ruta_pdf, $ruta_xml;

    // ? Variables modal
    public $switchModalSubida = false, $switchQuincena;

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

    public function cargaFactura()
    {
        $this->validate([
            'f_pdf' => 'required|mimes:pdf',
            'f_xml' => 'required|mimes:xml',
        ], [
            'f_pdf.required' => 'Este archivo es necesario',
            'f_pdf.mimes' => 'Este archivo debe ser PDF',
            'f_xml.required' => 'Este archivo es necesario',
            'f_xml.mimes' => 'Este archivo debe ser XML',
        ]);
        try {

            // ? Contruccion de ruta de acuerdo a la fecha actual
            $pre_ruta = $this->preparaRuta();

            // ? Extraccion y guardado de archivos
            $og_name_pdf = $this->f_pdf->getClientOriginalName();
            $this->ruta_pdf = $this->f_pdf->storeAS($pre_ruta . $this->colaborador[0]->no_colaborador,  $og_name_pdf, 'public');

            $og_name_xml = $this->f_xml->getClientOriginalName();
            $this->ruta_xml = $this->f_xml->storeAS($pre_ruta . $this->colaborador[0]->no_colaborador,  $og_name_xml, 'public');

            // ? Insercion de registro en la base de datos
            UserInvoice::create([
                'collaborators_id' => $this->colaborador[0]->id,
                'no_quincena' => $this->no_quincena,
                'ruta_pdf' => $this->ruta_pdf,
                'ruta_xml' => $this->ruta_xml,
                'comentarios' => $this->comentarios,
            ]);

            $this->flash(
                'success',
                'Se ha subido tu factura con éxito',
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

            return redirect()->route('panel-facturas-usuarios');
        } catch (Exception $ex) {
            dd($ex);
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

    public function preparaRuta()
    {
        $fecha_actual = Carbon::today();
        $year = $fecha_actual->year;
        $month = $fecha_actual->month;
        $day = $fecha_actual->day;
        $this->no_quincena = $day <= 15 ? 1 : 2;

        $ruta = 'facturas/' . $year . '/' . $month . '/' . $this->no_quincena . '/';

        return $ruta;
    }

    public function showModal()
    {
        $this->switchModalSubida = true;
    }

    public function hideModal()
    {
        $this->switchModalSubida = false;
    }
}

<?php

namespace App\Http\Livewire\Paneles;

use Exception;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\UserInvoice;
use App\Models\Collaborator;
use Illuminate\Filesystem\Filesystem;
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
    public $fecha_actual, $colaborador, $f_pdf, $f_xml, $comentarios, $year, $month, $day,
        $firstDayOfMonth, $lasttDayOfMonth, $no_quincena, $ruta_pdf, $ruta_xml, $facturas_quincena,
        $factura_id;

    // ? Variables modal
    public $switchModalSubida = false, $switchQuincena;

    // ? Declaracion de las variables que componen el queryString
    public $search, $perPage = '5';

    // ? Declaracion de variable para funcion de baja
    public $colaborador_id;

    // ? Inicio Alertas
    public function getListeners()
    {
        return [
            'eliminar',
            'cancelar',
        ];
    }

    // ? Funcion que arroja un cuadro de confirmacion y redirige a ciertas funciones 
    // ? dependiendo el boton que se presione
    public function triggerConfirm($id)
    {
        $this->confirm('¿Quieres eliminar esta factura?', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'eliminar',
            'inputAttributes' => $id,
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
            'Se canceló la eliminación',
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


    // ? Funcion que revisa antes de mostrar la vista si el usuario esta registrado como colaborador
    public function mount()
    {
        // ? Deconstruccion de fechas
        $this->fecha_actual = Carbon::today();
        $this->year = $this->fecha_actual->year;
        $this->month = $this->fecha_actual->month;
        $this->day = $this->fecha_actual->day;
        $this->no_quincena = $this->day <= 15 ? 1 : 2;
        $this->firstDayOfMonth = Carbon::today()->firstOfMonth();
        $this->lastDayOfMonth = Carbon::today()->lastOfMonth();

        // ? Carga de datos del colaborador
        $this->colaborador = Collaborator::where('correo', Auth::user()->email)->get();
        $this->facturas_quincena = $this->revisarFacturasQuincena();
        abort_if(count($this->colaborador) == 0, 403, 'No estás registrado aún, pide a un administrador que te registre como colaborador');
    }

    public function render()
    {
        return view('livewire.paneles.panel-facturas-usuarios', [
            'facturas' => DB::table('v_user_invoices')
                ->where('collaborators_id', $this->colaborador[0]->id)
                ->orWhere('created_at', 'LIKE', "%{$this->search}%")
                ->paginate($this->perPage)
        ]);
    }

    // ? Funcion que se encarga de eliminar el registro de la factura en la base de datos así como los archivos relacionados
    public function eliminar($data)
    {
        $this->factura_id = UserInvoice::find($data['data']['inputAttributes']);
        try {
            // ? Se guarda la ruta en varias variables para la posterior eliminacion del directorio
            list($root, $y, $m, $q, $nc) = explode("/", $this->factura_id->ruta_pdf);

            // ? Eliminacion de archivos individualmente
            Storage::delete('public/' . $this->factura_id->ruta_pdf);
            Storage::delete('public/' . $this->factura_id->ruta_xml);

            // ? Eliminacion de directorio en caso de estar vacio
            $directory = 'public/' . $root . "/" . $y . "/" . $m . "/" . $q . "/" . $nc;

            if (Storage::exists($directory)) {
                $files = Storage::files($directory);

                if (empty($files)) {
                    Storage::deleteDirectory($directory);
                }
            }

            // ? Eliminacion de registro en la base de datos
            $this->factura_id->delete();

            // ? Notificacion de exito tras redireccionamiento
            $this->flash(
                'success',
                'Se ha eliminado tu factura con éxito',
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

    // ? Funcion que construye la ruta en la que se guardaran los archivos de las facturas de acuerdo a la fecha actual
    public function preparaRuta()
    {
        $ruta = 'facturas/' . $this->year . '/' . $this->month . '/' . $this->no_quincena . '/';
        return $ruta;
    }

    // ? Funcion que revisa cuantas facturas se han subido en la quincena actual
    public function revisarFacturasQuincena()
    {
        try {
            $no_facturas = UserInvoice::where('collaborators_id', $this->colaborador[0]->id)
                ->whereBetween('created_at', [$this->firstDayOfMonth, $this->lastDayOfMonth])
                ->where('no_quincena', $this->no_quincena)
                ->count();

            return $no_facturas;
        } catch (Exception $err) {
            return "No existen facturas";
        }
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

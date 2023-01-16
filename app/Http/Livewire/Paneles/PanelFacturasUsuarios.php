<?php

namespace App\Http\Livewire\Paneles;

use App\Mail\FacturasUsuarios;
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
use Illuminate\Support\Facades\Mail;
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
    public $fecha_actual, $colaborador, $f_pdf, $fXml, $comentarios, $year, $month, $day,
        $firstDayOfMonth, $lastDayOfMonth, $no_quincena, $ruta_pdf, $ruta_xml, $facturas_quincena,
        $factura_id, $montoTotal, $moneda, $fechaTimbrado;

    // ? Variables modal
    public $switchModalSubida = false, $switchQuincena, $switchXml = true;

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
                ->where('created_at', 'LIKE', "%{$this->search}%")
                ->orderByDesc('id')
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
            'fXml' => 'required|mimes:xml',
        ], [
            'f_pdf.required' => 'Este archivo es necesario',
            'f_pdf.mimes' => 'Este archivo debe ser PDF',
            'fXml.required' => 'Este archivo es necesario',
            'fXml.mimes' => 'Este archivo debe ser XML',
        ]);
        try {

            // ? Contruccion de ruta de acuerdo a la fecha actual
            $pre_ruta = $this->preparaRuta();

            // ? Extraccion y guardado de archivos
            $og_name_pdf = $this->f_pdf->getClientOriginalName();
            $this->ruta_pdf = $this->f_pdf->storeAS($pre_ruta . $this->colaborador[0]->no_colaborador,  $og_name_pdf, 'public');

            $og_name_xml = $this->fXml->getClientOriginalName();
            $this->ruta_xml = $this->fXml->storeAS($pre_ruta . $this->colaborador[0]->no_colaborador,  $og_name_xml, 'public');

            // ? Insercion de registro en la base de datos
            UserInvoice::create([
                'collaborators_id' => $this->colaborador[0]->id,
                'no_quincena' => $this->no_quincena,
                'ruta_pdf' => $this->ruta_pdf,
                'ruta_xml' => $this->ruta_xml,
                'monto_total' => $this->montoTotal,
                'moneda' => $this->moneda,
                'fecha_timbrado' => $this->fechaTimbrado,
                'comentarios' => $this->comentarios,
            ]);

            // ? Envio de correo
            Mail::to('info@silcon.tech')->send(new FacturasUsuarios(
                $this->colaborador[0]->nombre_1,
                $this->colaborador[0]->ap_paterno,
                $this->montoTotal,
                $this->moneda,
                $this->fechaTimbrado,
            ));

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

    // ? Funcion que valida que el archivo xml corresponda con su RFC
    // ? Al RFC del usuario que esta realizando la subida de la misma
    public function updatedFXml()
    {
        // * Se activa el boton de subida (Esto para cuando se corrige el archivo) 
        $this->switchXml = true;
        // * Se estrae el RFC del colaborador que actualmente inicio sesion (vease la funcion mount)
        $rfc = $this->colaborador[0]->rfc;

        // ? Inicia el tratamiento del archivo
        // * Se solicita el archivo temporal del xml y se guarda en la variable contents
        $contents = Storage::disk('local')->get("livewire-tmp/" . $this->fXml->getFilename());
        // * Se reemplazan las etiquetas que impiden la lectura completa del archivo
        $contents = str_replace("<tfd:", "<cfdi:", $contents);
        $contents = str_replace("<cfdi:", "<", $contents);
        $contents = str_replace("</cfdi:", "</", $contents);
        // * Se convierte la cadena contents en un objeto de tipo simplexml
        $ob = simplexml_load_string($contents);
        // * Para poder acceder a todos los niveles del objeto, lo pasamos a JSON y despues a un Array asociativo
        $json = json_encode($ob);
        $arrayXml = json_decode($json, true);

        // * Validacion de RFC del Usuario con el del emisor de la factura
        // * Si no coinciden se manda una alerta para explicar que ambos RFC deben coincidir
        // * Al no coincidir los RFC, se elimina el boton de subida hasta que estos coincidan
        if ($rfc != $arrayXml["Emisor"]["@attributes"]["Rfc"]) {
            $this->switchXml = false;
            $this->alert('warning', 'Inconsistencia de datos', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'text' => 'El RFC del emisor de esta factura, no coincide con el RFC registrado de este usuario.

                Intenta subir un archivo XML con tu RFC o pide a un administrador que corrija el RFC registrado en tu usuario.',
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Ok',
                'timerProgressBar' => false,
            ]);
        } else {
            // * Si coinciden ambos RFC entonces se guardan los datos
            // * monto total, moneda y fecha de timbrado para su posterior subida a la BD
            $this->montoTotal = $arrayXml["@attributes"]["Total"];
            $this->moneda = $arrayXml["@attributes"]["Moneda"];
            $this->fechaTimbrado = Carbon::parse($arrayXml["Complemento"]["TimbreFiscalDigital"]["@attributes"]["FechaTimbrado"]);
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

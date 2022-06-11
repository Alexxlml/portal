<?php

namespace App\Http\Livewire\Paneles;

use App\Exports\UserInvoicesExport;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\UserInvoice;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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

    // ? Variables de funcion que genera reportes
    public $reporte, $tipo_reporte, $fecha_inicial, $fecha_final;

    // ? Variable para mostrar el modal
    public $switchModalExport = false;

    // ? Reglas para verificar que las fechas sean obligatorias 
    // ? ademas de que la fecha inicial no puede ser mayor que la final
    protected $rules = [
        'fecha_inicial'      => 'required|date|before:fecha_final',
        'fecha_final'        => 'required|date|after:fecha_inicial',
    ];

    // ? Mensajes personalizados de error
    protected $messages = [
        'fecha_inicial.required' => 'La fecha inicial es obligatoria',
        'fecha_inicial.date' => 'Debes ingresar una fecha válida',
        'fecha_inicial.before' => 'La fecha inicial no puede ser posterior o igual a la fecha final',
        'fecha_final.required' => 'La fecha final es obligatoria',
        'fecha_final.date' => 'Debes ingresar una fecha válida',
        'fecha_final.after' => 'La fecha final no puede ser anterior o igual a la fecha inicial',
    ];

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

    public function export()
    {
        // ? Si las reglas se cumplen se genera el reporte
        return $this->generateExportData($this->tipo_reporte);
    }

    public function generateExportData($t_reporte)
    {
        $this->fecha_actual = Carbon::now();
        if ($t_reporte == 1) {
            $this->reporte = DB::table('v_user_invoices')
                ->select(
                    'id',
                    'no_colaborador',
                    'nombre_completo',
                    'no_quincena',
                    'ruta_pdf',
                    'ruta_xml',
                    'comentarios',
                    'year',
                    'month',
                    'created_at'
                )
                ->get();
            $reporte = Excel::download(new UserInvoicesExport($this->reporte), 'Reporte-General-Facturas(' . $this->fecha_actual . ').xlsx');
        } elseif ($t_reporte == 2) {
            // ? Se ejecuta la validacion de fechas de acuerdo a las reglas establecidas
            $this->validate();
            // ? Conversion de fecha para añadir horas, minutos y segundos con Carbon
            // ? Esto se realiza para que la fecha final abarque al final del dia
            $dt = Carbon::create($this->fecha_final);
            $dt->toDateTimeString();
            $fFinal = $dt->addHours(23)->addMinutes(59)->addSeconds(59);

            $this->reporte = DB::table('v_user_invoices')
                ->select(
                    'id',
                    'no_colaborador',
                    'nombre_completo',
                    'no_quincena',
                    'ruta_pdf',
                    'ruta_xml',
                    'comentarios',
                    'year',
                    'month',
                    'created_at'
                )
                ->whereBetween('created_at', [$this->fecha_inicial, $fFinal])
                ->get();
            $reporte = Excel::download(new UserInvoicesExport($this->reporte), 'Reporte-Facturas-del (' . $this->fecha_inicial . ') al (' . $this->fecha_final . ').xlsx');
        }

        return $reporte;
    }

    public function showModal()
    {
        $this->switchModalExport = true;
    }
    public function hideModal()
    {
        $this->switchModalExport = false;
        $this->tipo_reporte = null;
        $this->fecha_inicial = null;
        $this->fecha_final = null;
    }
}

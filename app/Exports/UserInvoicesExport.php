<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserInvoicesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    protected $facturas;

    public function __construct($facturas)
    {
        $this->facturas = $facturas;
    }

    public function headings(): array
    {
        return [
            'ID',
            'No. Colaborador',
            'Nombre',
            'No. Quincena',
            'PDF',
            'XML',
            'Comentarios',
            'Fecha de carga',
        ];
    }

    public function collection()
    {
        return $this->facturas;
    }
}

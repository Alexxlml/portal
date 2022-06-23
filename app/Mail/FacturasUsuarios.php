<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FacturasUsuarios extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $nombre_1;
     protected $ap_paterno;
     protected $montoTotal;
     protected $moneda;
     protected $fechaTimbrado;

    public function __construct($nombre_1, $ap_paterno, $montoTotal, $moneda, $fechaTimbrado)
    {
        $this->nombre_1 = $nombre_1;
        $this->ap_paterno = $ap_paterno;
        $this->montoTotal = $montoTotal;
        $this->moneda = $moneda;
        $this->fechaTimbrado = $fechaTimbrado;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nueva factura')->markdown('emails.facturas')->with([
            'nombre_1' => $this->nombre_1,
            'ap_paterno' => $this->ap_paterno,
            'montoTotal' => $this->montoTotal,
            'moneda' => $this->moneda,
            'fechaTimbrado' => $this->fechaTimbrado,
        ]);
    }
}

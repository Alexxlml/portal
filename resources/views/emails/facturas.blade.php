@component('mail::message')
# Nueva factura de {{ $nombre_1 }} {{ $ap_paterno }}

Datos de la factura:

@component('mail::panel')
Monto: ${{ $montoTotal }} {{ $moneda }}<br>
Fecha de timbrado: {{ $fechaTimbrado }}
@endcomponent

@component('mail::button', ['url' => 'https://portal.silcon.tech'])
Ir
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent

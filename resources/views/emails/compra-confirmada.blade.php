<x-mail::message>
# Compra confirmada

Hola {{ $reservacion->user->name }}, registramos tu compra con el folio **{{ $reservacion->folio }}**.

<x-mail::panel>
**Paquete:** {{ $reservacion->viaje->nombre }}  
**Destino:** {{ $reservacion->viaje->destino->nombre }}, {{ $reservacion->viaje->destino->pais }}  
**Fechas:** {{ $reservacion->viaje->fecha_inicio->format('d/m/Y') }} - {{ $reservacion->viaje->fecha_fin->format('d/m/Y') }}  
**Hospedaje:** {{ $reservacion->viaje->hospedaje?->nombre ?? 'Sin hospedaje incluido' }}  
**Transporte:** {{ $reservacion->viaje->transporte->tipo }} desde {{ $reservacion->viaje->transporte->origen }}  
**Monto pagado:** ${{ number_format($reservacion->monto_pagado, 2) }}
</x-mail::panel>

<x-mail::button :url="route('reservaciones.show', $reservacion)">
Ver reservacion
</x-mail::button>

Presenta tu folio en sucursal si necesitas verificar tu compra.
</x-mail::message>

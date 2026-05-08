<x-mail::message>
# Reservacion cancelada

Hola {{ $reservacion->user->name }}, tu reservacion **{{ $reservacion->folio }}** fue cancelada correctamente.

<x-mail::panel>
**Paquete:** {{ $reservacion->viaje->nombre }}  
**Destino:** {{ $reservacion->viaje->destino->nombre }}  
**Politica:** las cancelaciones quedan sujetas a revision administrativa para cualquier reembolso aplicable.
</x-mail::panel>

Puedes revisar el historial desde tu panel.
</x-mail::message>

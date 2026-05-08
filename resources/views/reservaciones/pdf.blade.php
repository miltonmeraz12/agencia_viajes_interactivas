<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Ticket {{ $reservacion->folio }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color:#111827; margin:0; padding:28px; }
        .ticket { border:1px solid #cbd5e1; border-radius:10px; overflow:hidden; }
        .header { background:#111827; color:#fff; padding:24px; }
        .brand { font-size:24px; font-weight:700; }
        .folio { color:#f59e0b; font-size:26px; font-weight:700; letter-spacing:2px; text-align:right; }
        .body { padding:24px; }
        table { width:100%; border-collapse:collapse; }
        td { padding:11px 0; border-bottom:1px solid #e5e7eb; vertical-align:top; }
        .label { color:#64748b; font-size:11px; text-transform:uppercase; font-weight:700; }
        .value { font-size:15px; font-weight:700; margin-top:3px; }
        .total { background:#f8fafc; padding:18px; margin-top:24px; border:1px solid #e2e8f0; border-radius:8px; text-align:right; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <table><tr><td style="border:0"><div class="brand">Agencia de Viajes</div><div>Ticket de compra</div></td><td style="border:0" class="folio">{{ $reservacion->folio }}</td></tr></table>
        </div>
        <div class="body">
            <table>
                <tr><td><div class="label">Viajero</div><div class="value">{{ $reservacion->user->name }}</div></td><td><div class="label">Correo</div><div class="value">{{ $reservacion->user->email }}</div></td></tr>
                <tr><td><div class="label">Paquete</div><div class="value">{{ $reservacion->viaje->nombre }}</div></td><td><div class="label">Destino</div><div class="value">{{ $reservacion->viaje->destino->nombre }}, {{ $reservacion->viaje->destino->pais }}</div></td></tr>
                <tr><td><div class="label">Salida</div><div class="value">{{ $reservacion->viaje->fecha_inicio->format('d/m/Y') }}</div></td><td><div class="label">Regreso</div><div class="value">{{ $reservacion->viaje->fecha_fin->format('d/m/Y') }}</div></td></tr>
                <tr><td><div class="label">Hospedaje</div><div class="value">{{ $reservacion->viaje->hospedaje?->nombre ?? 'Sin hospedaje incluido' }}</div></td><td><div class="label">Transporte</div><div class="value">{{ $reservacion->viaje->transporte->tipo }} - {{ $reservacion->viaje->transporte->origen }} a {{ $reservacion->viaje->transporte->destino }}</div></td></tr>
            </table>
            <div class="total">
                <div class="label">Monto pagado</div>
                <div style="font-size:28px;font-weight:700">${{ number_format($reservacion->monto_pagado, 2) }}</div>
            </div>
            <p style="margin-top:22px;color:#64748b;font-size:12px">Codigo de reservacion alfanumerico de 8 caracteres para verificacion en sucursal: <strong>{{ $reservacion->folio }}</strong>.</p>
        </div>
    </div>
</body>
</html>

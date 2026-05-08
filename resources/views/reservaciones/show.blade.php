@extends('layouts.app')
@section('title', 'Reservacion '.$reservacion->folio)
@section('page-title', 'Reservacion '.$reservacion->folio)

@section('content')
<div class="mx-auto grid max-w-6xl gap-6 lg:grid-cols-[1fr_340px]">
    <div class="space-y-6">
        <div class="card p-6">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                <div>
                    <p class="text-sm font-bold uppercase tracking-widest text-teal-700">{{ $reservacion->estado }}</p>
                    <h2 class="mt-2 text-2xl font-extrabold">{{ $reservacion->viaje->nombre }}</h2>
                    <p class="mt-2 text-slate-600">{{ $reservacion->viaje->destino->nombre }}, {{ $reservacion->viaje->destino->pais }}</p>
                </div>
                <span class="rounded-lg bg-slate-950 px-4 py-3 font-mono text-lg font-extrabold text-white">{{ $reservacion->folio }}</span>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Viajero</p><p class="mt-2 font-extrabold">{{ $reservacion->user->name }}</p><p class="text-sm text-slate-500">{{ $reservacion->user->email }}</p></div>
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Fechas</p><p class="mt-2 font-extrabold">{{ $reservacion->viaje->fecha_inicio->format('d/m/Y') }} - {{ $reservacion->viaje->fecha_fin->format('d/m/Y') }}</p></div>
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Hospedaje</p><p class="mt-2 font-extrabold">{{ $reservacion->viaje->hospedaje?->nombre ?? 'Sin hospedaje' }}</p></div>
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Transporte</p><p class="mt-2 font-extrabold">{{ $reservacion->viaje->transporte->tipo }}</p><p class="text-sm text-slate-500">{{ $reservacion->viaje->transporte->origen }} a {{ $reservacion->viaje->transporte->destino }}</p></div>
        </div>
    </div>

    <aside class="card h-fit p-6">
        <p class="text-sm font-bold text-slate-500">Monto pagado</p>
        <p class="mt-2 text-4xl font-extrabold">${{ number_format($reservacion->monto_pagado, 2) }}</p>
        <div class="mt-6 grid gap-3">
            <a href="{{ route('reservaciones.pdf', $reservacion) }}" class="btn-primary w-full"><i class="fa-solid fa-file-pdf"></i> Descargar ticket</a>
            <form method="POST" action="{{ route('reservaciones.email', $reservacion) }}">@csrf<button class="btn-light w-full"><i class="fa-solid fa-envelope"></i> Reenviar correo</button></form>
            @if(! in_array($reservacion->estado, ['cancelado', 'completado']))
                <form method="POST" action="{{ route('reservaciones.cancelar', $reservacion) }}">
                    @csrf @method('PATCH')
                    <button class="btn-light w-full text-red-700" onclick="return confirm('Cancelar esta reservacion?')"><i class="fa-solid fa-ban"></i> Cancelar viaje</button>
                </form>
            @endif
        </div>
    </aside>
</div>
@endsection

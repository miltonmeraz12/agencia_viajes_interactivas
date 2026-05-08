@extends('layouts.app')
@section('title', $viaje->nombre)
@section('page-title', $viaje->nombre)

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="card p-6">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-teal-700">{{ $viaje->destino->nombre }}, {{ $viaje->destino->pais }}</p>
                <h2 class="mt-2 text-2xl font-extrabold">{{ $viaje->nombre }}</h2>
                <p class="mt-2 text-slate-600">{{ $viaje->fecha_inicio->format('d/m/Y') }} - {{ $viaje->fecha_fin->format('d/m/Y') }}</p>
            </div>
            <a href="{{ route('viajes.edit', $viaje) }}" class="btn-primary"><i class="fa-solid fa-pen"></i> Editar</a>
        </div>
        <div class="mt-6 grid gap-4 md:grid-cols-4">
            <div class="rounded-lg bg-slate-50 p-4"><p class="text-sm text-slate-500">Precio</p><p class="font-extrabold">${{ number_format($viaje->precio_total, 2) }}</p></div>
            <div class="rounded-lg bg-slate-50 p-4"><p class="text-sm text-slate-500">Capacidad</p><p class="font-extrabold">{{ $viaje->capacidad }}</p></div>
            <div class="rounded-lg bg-slate-50 p-4"><p class="text-sm text-slate-500">Disponibles</p><p class="font-extrabold">{{ $viaje->lugaresDisponibles() }}</p></div>
            <div class="rounded-lg bg-slate-50 p-4"><p class="text-sm text-slate-500">Reservas</p><p class="font-extrabold">{{ $viaje->reservaciones->count() }}</p></div>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="border-b border-slate-200 p-5"><h3 class="font-extrabold">Reservaciones del paquete</h3></div>
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500"><tr><th class="p-4">Folio</th><th class="p-4">Cliente</th><th class="p-4">Estado</th><th class="p-4 text-right">Monto</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($viaje->reservaciones as $reserva)
                    <tr><td class="p-4 font-mono font-bold">{{ $reserva->folio }}</td><td class="p-4">{{ $reserva->user->name }}</td><td class="p-4">{{ $reserva->estado }}</td><td class="p-4 text-right">${{ number_format($reserva->monto_pagado, 2) }}</td></tr>
                @empty
                    <tr><td colspan="4" class="p-8 text-center text-slate-500">Sin reservaciones.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

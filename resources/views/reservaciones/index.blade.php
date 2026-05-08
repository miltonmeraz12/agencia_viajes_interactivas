@extends('layouts.app')
@section('title', 'Reservaciones')
@section('page-title', auth()->user()->isAdmin() ? 'Reservaciones de clientes' : 'Mis reservaciones')

@section('content')
<div class="mx-auto max-w-7xl space-y-5">
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr><th class="p-4">Folio</th><th class="p-4">Paquete</th>@if(auth()->user()->isAdmin())<th class="p-4">Cliente</th>@endif<th class="p-4">Estado</th><th class="p-4">Fecha</th><th class="p-4 text-right">Total</th><th class="p-4 text-right">Acciones</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reservaciones as $reserva)
                        <tr>
                            <td class="p-4 font-mono font-bold">{{ $reserva->folio }}</td>
                            <td class="p-4">
                                <p class="font-bold">{{ $reserva->viaje->nombre }}</p>
                                <p class="text-xs text-slate-500">{{ $reserva->viaje->destino->nombre }}</p>
                            </td>
                            @if(auth()->user()->isAdmin())<td class="p-4">{{ $reserva->user->name }}</td>@endif
                            <td class="p-4"><span class="badge bg-slate-100 text-slate-700">{{ $reserva->estado }}</span></td>
                            <td class="p-4">{{ $reserva->created_at->format('d/m/Y') }}</td>
                            <td class="p-4 text-right font-bold">${{ number_format($reserva->monto_pagado, 2) }}</td>
                            <td class="p-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('reservaciones.show', $reserva) }}" class="btn-light !px-3"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('reservaciones.pdf', $reserva) }}" class="btn-light !px-3 text-red-700"><i class="fa-solid fa-file-pdf"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="p-10 text-center text-slate-500">No hay reservaciones registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $reservaciones->links() }}
</div>
@endsection

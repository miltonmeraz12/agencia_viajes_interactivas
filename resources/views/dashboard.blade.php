@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', auth()->user()->isAdmin() ? 'Dashboard administrativo' : 'Mi panel de viajes')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    @if(auth()->user()->isAdmin())
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Reservaciones</p><p class="mt-2 text-3xl font-extrabold">{{ $totalReservas }}</p></div>
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Paquetes</p><p class="mt-2 text-3xl font-extrabold">{{ $totalPaquetes }}</p></div>
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Destinos</p><p class="mt-2 text-3xl font-extrabold">{{ $totalDestinos }}</p></div>
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Clientes</p><p class="mt-2 text-3xl font-extrabold">{{ $totalUsuarios }}</p></div>
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Ingresos</p><p class="mt-2 text-3xl font-extrabold">${{ number_format($ingresos, 2) }}</p></div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="card p-5 lg:col-span-2">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="font-extrabold">Ventas por mes</h2>
                        <p class="text-sm text-slate-500">Reservaciones creadas durante {{ now()->year }}.</p>
                    </div>
                    <a href="{{ route('viajes.create') }}" class="btn-primary"><i class="fa-solid fa-plus"></i> Nuevo paquete</a>
                </div>
                <div class="h-72"><canvas id="ventasChart"></canvas></div>
            </div>
            <div class="card p-5">
                <h2 class="font-extrabold">Estado de reservas</h2>
                <p class="text-sm text-slate-500">Confirmadas, pendientes y canceladas.</p>
                <div class="mt-6 h-64"><canvas id="estadoChart"></canvas></div>
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="border-b border-slate-200 p-5">
                <h2 class="font-extrabold">Reservaciones recientes</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr><th class="p-4">Folio</th><th class="p-4">Cliente</th><th class="p-4">Paquete</th><th class="p-4">Estado</th><th class="p-4 text-right">Monto</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($reservacionesRecientes as $reserva)
                            <tr>
                                <td class="p-4 font-mono font-bold">{{ $reserva->folio }}</td>
                                <td class="p-4">{{ $reserva->user->name }}</td>
                                <td class="p-4">{{ $reserva->viaje->nombre }}</td>
                                <td class="p-4"><span class="badge bg-slate-100 text-slate-700">{{ $reserva->estado }}</span></td>
                                <td class="p-4 text-right font-bold">${{ number_format($reserva->monto_pagado, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-8 text-center text-slate-500">Aun no hay reservaciones.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @push('scripts')
        <script>
            new Chart(document.getElementById('ventasChart'), {
                type: 'bar',
                data: { labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'], datasets: [{ data: @json($meses), backgroundColor: '#0f766e', borderRadius: 6 }] },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
            });
            new Chart(document.getElementById('estadoChart'), {
                type: 'doughnut',
                data: { labels: ['Confirmado','Pendiente','Cancelado'], datasets: [{ data: @json($estadosReserva), backgroundColor: ['#0f766e','#f59e0b','#ef4444'] }] },
                options: { responsive: true, maintainAspectRatio: false }
            });
        </script>
        @endpush
    @else
        <div class="card overflow-hidden">
            <div class="grid gap-6 p-6 lg:grid-cols-[1.4fr_.8fr] lg:p-8">
                <div>
                    <p class="text-sm font-bold uppercase tracking-widest text-teal-700">Hola, {{ explode(' ', auth()->user()->name)[0] }}</p>
                    <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Tus viajes y compras en un solo lugar</h2>
                    <p class="mt-3 max-w-2xl text-slate-600">Explora paquetes, confirma tu compra y descarga el ticket PDF con folio de verificacion.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('viajes.catalogo') }}" class="btn-primary"><i class="fa-solid fa-compass"></i> Explorar paquetes</a>
                        <a href="{{ route('reservaciones.index') }}" class="btn-light"><i class="fa-solid fa-ticket"></i> Historial</a>
                    </div>
                </div>
                <div class="rounded-lg bg-slate-950 p-6 text-white">
                    <p class="text-sm font-bold text-slate-400">Viajes comprados</p>
                    <p class="mt-3 text-5xl font-extrabold">{{ $misReservasCount }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="card p-5">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-extrabold">Mis ultimas reservaciones</h2>
                    <a href="{{ route('reservaciones.index') }}" class="text-sm font-bold text-teal-700">Ver todo</a>
                </div>
                <div class="space-y-3">
                    @forelse($misUltimasReservas as $reserva)
                        <a href="{{ route('reservaciones.show', $reserva) }}" class="block rounded-lg border border-slate-200 p-4 hover:border-teal-600">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-bold">{{ $reserva->viaje->nombre }}</p>
                                    <p class="text-sm text-slate-500">{{ $reserva->viaje->destino->nombre }} - {{ $reserva->viaje->fecha_inicio->format('d/m/Y') }}</p>
                                </div>
                                <span class="badge bg-slate-100 text-slate-700">{{ $reserva->estado }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="rounded-lg border border-dashed border-slate-300 p-8 text-center text-slate-500">Aun no has comprado paquetes.</div>
                    @endforelse
                </div>
            </div>

            <div class="card p-5">
                <h2 class="mb-4 font-extrabold">Paquetes destacados</h2>
                <div class="space-y-3">
                    @foreach($paquetesDestacados as $viaje)
                        <a href="{{ route('viajes.catalogo.show', $viaje) }}" class="block rounded-lg border border-slate-200 p-4 hover:border-teal-600">
                            <p class="font-bold">{{ $viaje->nombre }}</p>
                            <p class="text-sm text-slate-500">{{ $viaje->destino->nombre }} - ${{ number_format($viaje->precio_total, 2) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

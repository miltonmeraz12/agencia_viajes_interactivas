@extends('layouts.app')
@section('title', 'Paquetes')
@section('page-title', 'Paquetes disponibles')
@section('eyebrow', 'Catalogo para clientes')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <section class="card overflow-hidden">
        <div class="grid gap-6 p-6 lg:grid-cols-[1.4fr_.7fr] lg:p-8">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-teal-700">Compra segura con folio y ticket PDF</p>
                <h2 class="mt-3 text-3xl font-extrabold text-slate-950">Elige tu siguiente viaje</h2>
                <p class="mt-3 max-w-2xl text-slate-600">Cada paquete incluye destino, hospedaje, transporte, fechas, capacidad disponible y confirmacion por correo.</p>
            </div>
            <form method="GET" class="grid gap-3 rounded-lg bg-slate-50 p-4">
                <input name="search" value="{{ request('search') }}" class="field" placeholder="Buscar por destino o paquete">
                <select name="pais" class="field">
                    <option value="">Todos los paises</option>
                    @foreach($paises as $pais)
                        <option value="{{ $pais }}" @selected(request('pais') === $pais)>{{ $pais }}</option>
                    @endforeach
                </select>
                <input name="precio_max" value="{{ request('precio_max') }}" type="number" min="0" class="field" placeholder="Precio maximo">
                <button class="btn-primary"><i class="fa-solid fa-filter"></i> Filtrar</button>
            </form>
        </div>
    </section>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($viajes as $viaje)
            <article class="card overflow-hidden">
                <div class="grid h-44 place-items-center bg-slate-200 text-slate-500">
                    @if($viaje->destino->imagenPrincipal())
                        <img src="{{ asset('storage/'.$viaje->destino->imagenPrincipal()) }}" class="h-full w-full object-cover" alt="{{ $viaje->destino->nombre }}">
                    @else
                        <div class="text-center">
                            <i class="fa-solid fa-map-location-dot text-4xl"></i>
                            <p class="mt-2 text-sm font-bold">{{ $viaje->destino->pais }}</p>
                        </div>
                    @endif
                </div>
                <div class="space-y-4 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-extrabold">{{ $viaje->nombre }}</h3>
                            <p class="text-sm text-slate-500">{{ $viaje->destino->nombre }}, {{ $viaje->destino->pais }}</p>
                        </div>
                        <span class="badge {{ $viaje->lugaresDisponibles() > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ $viaje->lugaresDisponibles() }} lugares</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm text-slate-600">
                        <p><i class="fa-solid fa-calendar mr-2 text-teal-700"></i>{{ $viaje->fecha_inicio->format('d/m/Y') }}</p>
                        <p><i class="fa-solid fa-hotel mr-2 text-teal-700"></i>{{ $viaje->hospedaje?->categoria ?? 'Sin hotel' }}</p>
                        <p><i class="fa-solid fa-bus mr-2 text-teal-700"></i>{{ $viaje->transporte->tipo }}</p>
                        <p><i class="fa-solid fa-user-group mr-2 text-teal-700"></i>{{ $viaje->capacidad }} total</p>
                    </div>
                    <div class="flex items-center justify-between border-t border-slate-100 pt-4">
                        <p class="text-2xl font-extrabold">${{ number_format($viaje->precio_total, 2) }}</p>
                        <a href="{{ route('viajes.catalogo.show', $viaje) }}" class="btn-dark">Ver detalle</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="card p-10 text-center text-slate-500 md:col-span-2 xl:col-span-3">No hay paquetes disponibles con esos filtros.</div>
        @endforelse
    </div>

    {{ $viajes->links() }}
</div>
@endsection

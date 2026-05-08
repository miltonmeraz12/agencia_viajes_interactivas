@extends('layouts.app')
@section('title', $viaje->nombre)
@section('page-title', $viaje->nombre)
@section('eyebrow', 'Detalle del paquete')

@section('content')
<div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-[1fr_380px]">
    <div class="space-y-6">
        <div class="card overflow-hidden">
            <div class="grid h-72 place-items-center bg-slate-200 text-slate-500">
                @if($viaje->destino->imagenPrincipal())
                    <img src="{{ asset('storage/'.$viaje->destino->imagenPrincipal()) }}" class="h-full w-full object-cover" alt="{{ $viaje->destino->nombre }}">
                @else
                    <div class="text-center">
                        <i class="fa-solid fa-earth-americas text-6xl"></i>
                        <p class="mt-3 font-bold">{{ $viaje->destino->nombre }}</p>
                    </div>
                @endif
            </div>
            <div class="p-6">
                <h2 class="text-2xl font-extrabold">{{ $viaje->destino->nombre }}, {{ $viaje->destino->pais }}</h2>
                <p class="mt-3 text-slate-600">{{ $viaje->destino->descripcion }}</p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Salida</p><p class="mt-2 font-extrabold">{{ $viaje->fecha_inicio->format('d/m/Y') }}</p></div>
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Regreso</p><p class="mt-2 font-extrabold">{{ $viaje->fecha_fin->format('d/m/Y') }}</p></div>
            <div class="card p-5"><p class="text-sm font-bold text-slate-500">Disponibles</p><p class="mt-2 font-extrabold">{{ $viaje->lugaresDisponibles() }} lugares</p></div>
        </div>

        <div class="card p-6">
            <h3 class="font-extrabold">Incluye</h3>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-slate-200 p-4">
                    <p class="font-bold"><i class="fa-solid fa-hotel mr-2 text-teal-700"></i>{{ $viaje->hospedaje?->nombre ?? 'Sin hospedaje' }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $viaje->hospedaje?->categoria ?? 'Este paquete no incluye hospedaje.' }}</p>
                </div>
                <div class="rounded-lg border border-slate-200 p-4">
                    <p class="font-bold"><i class="fa-solid fa-route mr-2 text-teal-700"></i>{{ $viaje->transporte->tipo }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $viaje->transporte->origen }} a {{ $viaje->transporte->destino }}</p>
                </div>
            </div>
        </div>
    </div>

    <aside class="card h-fit p-6 lg:sticky lg:top-24">
        <p class="text-sm font-bold uppercase tracking-widest text-teal-700">Total por persona</p>
        <p class="mt-2 text-4xl font-extrabold">${{ number_format($viaje->precio_total, 2) }}</p>
        <p class="mt-3 text-sm text-slate-500">Al comprar se generara un folio unico de 8 caracteres, correo de confirmacion y ticket PDF.</p>

        @auth
            @if($viaje->lugaresDisponibles() > 0)
                <form method="POST" action="{{ route('reservaciones.store') }}" class="mt-6">
                    @csrf
                    <input type="hidden" name="viaje_id" value="{{ $viaje->id }}">
                    <button class="btn-primary w-full"><i class="fa-solid fa-credit-card"></i> Comprar paquete</button>
                </form>
            @else
                <div class="mt-6 rounded-lg bg-red-50 p-4 text-sm font-bold text-red-700">Este paquete no tiene disponibilidad.</div>
            @endif
        @else
            <div class="mt-6 grid gap-3">
                <a href="{{ route('login') }}" class="btn-primary w-full">Iniciar sesion para comprar</a>
                <a href="{{ route('register') }}" class="btn-light w-full">Crear cuenta</a>
            </div>
        @endauth
    </aside>
</div>
@endsection

@extends('layouts.app')
@section('title', $destino->nombre)
@section('page-title', $destino->nombre)

@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div class="card overflow-hidden">
        <div class="grid h-64 place-items-center bg-slate-200 text-slate-500">
            @if($destino->imagenPrincipal())<img src="{{ asset('storage/'.$destino->imagenPrincipal()) }}" class="h-full w-full object-cover" alt="{{ $destino->nombre }}">@else<i class="fa-solid fa-map-location-dot text-6xl"></i>@endif
        </div>
        <div class="p-6">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">
                <div><p class="text-sm font-bold uppercase tracking-widest text-teal-700">{{ $destino->pais }}</p><h2 class="mt-2 text-2xl font-extrabold">{{ $destino->nombre }}</h2></div>
                @if(auth()->user()->isAdmin())<a href="{{ route('destinos.edit', $destino) }}" class="btn-primary"><i class="fa-solid fa-pen"></i> Editar</a>@endif
            </div>
            <p class="mt-4 text-slate-600">{{ $destino->descripcion }}</p>
        </div>
    </div>
    <div class="grid gap-5 lg:grid-cols-2">
        <div class="card p-5"><h3 class="mb-4 font-extrabold">Hospedajes vinculados</h3>@forelse($destino->hospedajes as $h)<p class="border-b border-slate-100 py-3">{{ $h->nombre }} <span class="text-sm text-slate-500">({{ $h->categoria }})</span></p>@empty<p class="text-slate-500">Sin hospedajes.</p>@endforelse</div>
        <div class="card p-5"><h3 class="mb-4 font-extrabold">Paquetes disponibles</h3>@forelse($destino->viajes as $v)<p class="border-b border-slate-100 py-3">{{ $v->nombre }} <span class="text-sm text-slate-500">${{ number_format($v->precio_total, 2) }}</span></p>@empty<p class="text-slate-500">Sin paquetes.</p>@endforelse</div>
    </div>
</div>
@endsection

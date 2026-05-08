@extends('layouts.app')
@section('title', $hospedaje->nombre)
@section('page-title', $hospedaje->nombre)

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="card overflow-hidden">
        <div class="grid h-64 place-items-center bg-slate-200 text-slate-500">@if($hospedaje->imagenPrincipal())<img src="{{ asset('storage/'.$hospedaje->imagenPrincipal()) }}" class="h-full w-full object-cover" alt="{{ $hospedaje->nombre }}">@else<i class="fa-solid fa-hotel text-6xl"></i>@endif</div>
        <div class="p-6">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">
                <div><p class="text-sm font-bold uppercase tracking-widest text-teal-700">{{ ucfirst($hospedaje->categoria) }}</p><h2 class="mt-2 text-2xl font-extrabold">{{ $hospedaje->nombre }}</h2><p class="mt-2 text-slate-600">{{ $hospedaje->destino->nombre }}, {{ $hospedaje->destino->pais }}</p></div>
                @if(auth()->user()->isAdmin())<a href="{{ route('hospedajes.edit', $hospedaje) }}" class="btn-primary"><i class="fa-solid fa-pen"></i> Editar</a>@endif
            </div>
            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-lg bg-slate-50 p-4"><p class="text-sm text-slate-500">Precio noche</p><p class="font-extrabold">${{ number_format($hospedaje->precio_noche, 2) }}</p></div>
                <div class="rounded-lg bg-slate-50 p-4"><p class="text-sm text-slate-500">Habitaciones</p><p class="font-extrabold">{{ $hospedaje->habitaciones_disp }}</p></div>
                <div class="rounded-lg bg-slate-50 p-4"><p class="text-sm text-slate-500">Direccion</p><p class="font-extrabold">{{ $hospedaje->direccion ?? 'No registrada' }}</p></div>
            </div>
        </div>
    </div>
</div>
@endsection

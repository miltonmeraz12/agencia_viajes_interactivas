@extends('layouts.app')
@section('title', $transporte->tipo)
@section('page-title', $transporte->tipo)

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="card p-6">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-start">
            <div><p class="text-sm font-bold uppercase tracking-widest text-teal-700">{{ $transporte->origen }} a {{ $transporte->destino }}</p><h2 class="mt-2 text-2xl font-extrabold">{{ $transporte->tipo }}</h2></div>
            <a href="{{ route('transportes.edit', $transporte) }}" class="btn-primary"><i class="fa-solid fa-pen"></i> Editar</a>
        </div>
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            <div class="rounded-lg bg-slate-50 p-4"><p class="text-sm text-slate-500">Salida</p><p class="font-extrabold">{{ $transporte->fecha_salida->format('d/m/Y H:i') }}</p></div>
            <div class="rounded-lg bg-slate-50 p-4"><p class="text-sm text-slate-500">Disponibles</p><p class="font-extrabold">{{ $transporte->lugaresDisponibles() }} / {{ $transporte->capacidad }}</p></div>
            <div class="rounded-lg bg-slate-50 p-4"><p class="text-sm text-slate-500">Precio</p><p class="font-extrabold">${{ number_format($transporte->precio, 2) }}</p></div>
        </div>
    </div>
</div>
@endsection

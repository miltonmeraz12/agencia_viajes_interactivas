@extends('layouts.app')
@section('title', 'Agencia de Viajes')
@section('page-title', 'Agencia de Viajes')

@section('content')
    <div class="card p-8">
        <h2 class="text-2xl font-extrabold">Bienvenido</h2>
        <p class="mt-2 text-slate-600">Explora paquetes disponibles y compra tu siguiente viaje desde el catalogo.</p>
        <a href="{{ route('viajes.catalogo') }}" class="btn-primary mt-6">Ver paquetes</a>
    </div>
@endsection

@extends('layouts.app')
@section('title', 'Nuevo paquete')
@section('page-title', 'Nuevo paquete')

@section('content')
@include('viajes.form', ['action' => route('viajes.store'), 'method' => 'POST', 'viaje' => new \App\Models\Viaje()])
@endsection

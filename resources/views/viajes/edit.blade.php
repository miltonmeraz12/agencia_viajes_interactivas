@extends('layouts.app')
@section('title', 'Editar paquete')
@section('page-title', 'Editar paquete')

@section('content')
@include('viajes.form', ['action' => route('viajes.update', $viaje), 'method' => 'PUT'])
@endsection

@extends('layouts.app')
@section('title', 'Nuevo destino')
@section('page-title', 'Nuevo destino')
@section('content')
@include('destinos.form', ['action' => route('destinos.store'), 'method' => 'POST', 'destino' => new \App\Models\Destino(['activo' => true])])
@endsection

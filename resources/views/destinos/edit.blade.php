@extends('layouts.app')
@section('title', 'Editar destino')
@section('page-title', 'Editar destino')
@section('content')
@include('destinos.form', ['action' => route('destinos.update', $destino), 'method' => 'PUT'])
@endsection

@extends('layouts.app')
@section('title', 'Editar transporte')
@section('page-title', 'Editar transporte')
@section('content')
@include('transportes.form', ['action' => route('transportes.update', $transporte), 'method' => 'PUT'])
@endsection

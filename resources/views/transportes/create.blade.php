@extends('layouts.app')
@section('title', 'Nuevo transporte')
@section('page-title', 'Nuevo transporte')
@section('content')
@include('transportes.form', ['action' => route('transportes.store'), 'method' => 'POST', 'transporte' => new \App\Models\Transporte()])
@endsection

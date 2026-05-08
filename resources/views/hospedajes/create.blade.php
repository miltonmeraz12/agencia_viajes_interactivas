@extends('layouts.app')
@section('title', 'Nuevo hospedaje')
@section('page-title', 'Nuevo hospedaje')
@section('content')
@include('hospedajes.form', ['action' => route('hospedajes.store'), 'method' => 'POST', 'hospedaje' => new \App\Models\Hospedaje()])
@endsection

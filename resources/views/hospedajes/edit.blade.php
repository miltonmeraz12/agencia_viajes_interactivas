@extends('layouts.app')
@section('title', 'Editar hospedaje')
@section('page-title', 'Editar hospedaje')
@section('content')
@include('hospedajes.form', ['action' => route('hospedajes.update', $hospedaje), 'method' => 'PUT'])
@endsection

@extends('layouts.app')
@section('title', 'Perfil')
@section('page-title', 'Perfil')

@section('content')
<div class="mx-auto grid max-w-5xl gap-6 lg:grid-cols-[1fr_1fr]">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="card p-6">
        @csrf @method('PATCH')
        <h2 class="text-lg font-extrabold">Informacion personal</h2>
        <div class="mt-5 space-y-4">
            <div><label class="mb-2 block text-sm font-bold">Nombre</label><input name="name" value="{{ old('name', $user->name) }}" class="field" required></div>
            <div><label class="mb-2 block text-sm font-bold">Correo</label><input name="email" value="{{ old('email', $user->email) }}" type="email" class="field" required></div>
            <div><label class="mb-2 block text-sm font-bold">Telefono</label><input name="phone" value="{{ old('phone', $user->phone) }}" class="field"></div>
            <div><label class="mb-2 block text-sm font-bold">Fecha de nacimiento</label><input name="birth_date" value="{{ old('birth_date', optional($user->birth_date)->format('Y-m-d')) }}" type="date" class="field"></div>
            <div><label class="mb-2 block text-sm font-bold">Foto de perfil</label><input name="profile_photo" type="file" accept="image/*" class="field"></div>
        </div>
        <button class="btn-primary mt-6">Actualizar perfil</button>
    </form>

    <div class="space-y-6">
        @include('profile.partials.update-password-form')
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection

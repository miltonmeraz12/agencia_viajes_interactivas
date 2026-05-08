@extends('layouts.app')
@section('title', 'Hospedajes')
@section('page-title', 'Hospedajes')

@section('content')
<div class="mx-auto max-w-7xl space-y-5">
    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
        <form method="GET" class="grid flex-1 gap-3 sm:grid-cols-3">
            <input name="search" value="{{ request('search') }}" class="field" placeholder="Buscar hospedaje">
            <select name="categoria" class="field"><option value="">Todas las categorias</option>@foreach($categorias as $cat)<option value="{{ $cat }}" @selected(request('categoria') === $cat)>{{ ucfirst($cat) }}</option>@endforeach</select>
            <button class="btn-light"><i class="fa-solid fa-filter"></i> Filtrar</button>
        </form>
        @if(auth()->user()->isAdmin())<a href="{{ route('hospedajes.create') }}" class="btn-primary"><i class="fa-solid fa-plus"></i> Nuevo hospedaje</a>@endif
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($hospedajes as $hospedaje)
            <article class="card overflow-hidden">
                <div class="grid h-40 place-items-center bg-slate-200 text-slate-500">@if($hospedaje->imagenPrincipal())<img src="{{ asset('storage/'.$hospedaje->imagenPrincipal()) }}" class="h-full w-full object-cover" alt="{{ $hospedaje->nombre }}">@else<i class="fa-solid fa-hotel text-4xl"></i>@endif</div>
                <div class="p-5">
                    <h3 class="text-lg font-extrabold">{{ $hospedaje->nombre }}</h3>
                    <p class="text-sm text-slate-500">{{ $hospedaje->destino->nombre }} - {{ ucfirst($hospedaje->categoria) }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="font-extrabold">${{ number_format($hospedaje->precio_noche, 2) }} <span class="text-xs font-medium text-slate-500">/ noche</span></p>
                        <span class="badge bg-slate-100 text-slate-700">{{ $hospedaje->habitaciones_disp }} hab.</span>
                    </div>
                    <div class="mt-5 flex justify-end gap-2"><a href="{{ route('hospedajes.show', $hospedaje) }}" class="btn-light !px-3">Ver</a>@if(auth()->user()->isAdmin())<a href="{{ route('hospedajes.edit', $hospedaje) }}" class="btn-light !px-3"><i class="fa-solid fa-pen"></i></a>@endif</div>
                </div>
            </article>
        @empty
            <div class="card p-10 text-center text-slate-500 md:col-span-2 xl:col-span-3">No hay hospedajes registrados.</div>
        @endforelse
    </div>
    {{ $hospedajes->links() }}
</div>
@endsection

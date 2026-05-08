@extends('layouts.app')
@section('title', 'Destinos')
@section('page-title', 'Destinos')

@section('content')
<div class="mx-auto max-w-7xl space-y-5">
    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
        <form method="GET" class="grid flex-1 gap-3 sm:grid-cols-3">
            <input name="search" value="{{ request('search') }}" class="field" placeholder="Buscar destino">
            <select name="pais" class="field"><option value="">Todos los paises</option>@foreach($paises as $pais)<option value="{{ $pais }}" @selected(request('pais') === $pais)>{{ $pais }}</option>@endforeach</select>
            <button class="btn-light"><i class="fa-solid fa-filter"></i> Filtrar</button>
        </form>
        @if(auth()->user()->isAdmin())<a href="{{ route('destinos.create') }}" class="btn-primary"><i class="fa-solid fa-plus"></i> Nuevo destino</a>@endif
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($destinos as $destino)
            <article class="card overflow-hidden">
                <div class="grid h-40 place-items-center bg-slate-200 text-slate-500">
                    @if($destino->imagenPrincipal())<img src="{{ asset('storage/'.$destino->imagenPrincipal()) }}" class="h-full w-full object-cover" alt="{{ $destino->nombre }}">@else<i class="fa-solid fa-map-location-dot text-4xl"></i>@endif
                </div>
                <div class="p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div><h3 class="text-lg font-extrabold">{{ $destino->nombre }}</h3><p class="text-sm text-slate-500">{{ $destino->pais }}</p></div>
                        <span class="badge {{ $destino->activo ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $destino->activo ? 'Activo' : 'Inactivo' }}</span>
                    </div>
                    <p class="mt-3 line-clamp-3 text-sm text-slate-600">{{ $destino->descripcion }}</p>
                    <div class="mt-5 flex items-center justify-between">
                        <p class="font-extrabold">${{ number_format($destino->precio_base, 2) }}</p>
                        <div class="flex gap-2">
                            <a href="{{ route('destinos.show', $destino) }}" class="btn-light !px-3">Ver</a>
                            @if(auth()->user()->isAdmin())<a href="{{ route('destinos.edit', $destino) }}" class="btn-light !px-3"><i class="fa-solid fa-pen"></i></a>@endif
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="card p-10 text-center text-slate-500 md:col-span-2 xl:col-span-3">No hay destinos registrados.</div>
        @endforelse
    </div>
    {{ $destinos->links() }}
</div>
@endsection

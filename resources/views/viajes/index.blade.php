@extends('layouts.app')
@section('title', 'Gestion de paquetes')
@section('page-title', 'Gestion de paquetes')

@section('content')
<div class="mx-auto max-w-7xl space-y-5">
    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
        <p class="text-slate-600">Administra paquetes con destino, hospedaje, transporte, fechas, capacidad y precio.</p>
        <a href="{{ route('viajes.create') }}" class="btn-primary"><i class="fa-solid fa-plus"></i> Nuevo paquete</a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr><th class="p-4">Paquete</th><th class="p-4">Destino</th><th class="p-4">Fechas</th><th class="p-4">Capacidad</th><th class="p-4">Precio</th><th class="p-4 text-right">Acciones</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($viajes as $viaje)
                        <tr>
                            <td class="p-4 font-bold">{{ $viaje->nombre }}</td>
                            <td class="p-4">{{ $viaje->destino->nombre }}</td>
                            <td class="p-4">{{ $viaje->fecha_inicio->format('d/m/Y') }} - {{ $viaje->fecha_fin->format('d/m/Y') }}</td>
                            <td class="p-4">{{ $viaje->reservas_activas_count }} / {{ $viaje->capacidad }}</td>
                            <td class="p-4 font-bold">${{ number_format($viaje->precio_total, 2) }}</td>
                            <td class="p-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('viajes.show', $viaje) }}" class="btn-light !px-3"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('viajes.edit', $viaje) }}" class="btn-light !px-3"><i class="fa-solid fa-pen"></i></a>
                                    <form method="POST" action="{{ route('viajes.destroy', $viaje) }}">
                                        @csrf @method('DELETE')
                                        <button class="btn-light !px-3 text-red-700" onclick="return confirm('Desactivar este paquete?')"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-8 text-center text-slate-500">No hay paquetes registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $viajes->links() }}
</div>
@endsection

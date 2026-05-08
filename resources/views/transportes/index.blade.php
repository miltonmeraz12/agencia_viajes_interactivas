@extends('layouts.app')
@section('title', 'Transportes')
@section('page-title', 'Transportes')

@section('content')
<div class="mx-auto max-w-7xl space-y-5">
    <div class="flex justify-end"><a href="{{ route('transportes.create') }}" class="btn-primary"><i class="fa-solid fa-plus"></i> Nuevo transporte</a></div>
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500"><tr><th class="p-4">Tipo</th><th class="p-4">Ruta</th><th class="p-4">Salida</th><th class="p-4">Capacidad</th><th class="p-4">Precio</th><th class="p-4 text-right">Acciones</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transportes as $transporte)
                        <tr>
                            <td class="p-4 font-bold">{{ $transporte->tipo }}</td>
                            <td class="p-4">{{ $transporte->origen }} a {{ $transporte->destino }}</td>
                            <td class="p-4">{{ $transporte->fecha_salida->format('d/m/Y H:i') }}</td>
                            <td class="p-4">{{ $transporte->lugaresDisponibles() }} / {{ $transporte->capacidad }}</td>
                            <td class="p-4 font-bold">${{ number_format($transporte->precio, 2) }}</td>
                            <td class="p-4"><div class="flex justify-end gap-2"><a href="{{ route('transportes.edit', $transporte) }}" class="btn-light !px-3"><i class="fa-solid fa-pen"></i></a><form method="POST" action="{{ route('transportes.destroy', $transporte) }}">@csrf @method('DELETE')<button class="btn-light !px-3 text-red-700" onclick="return confirm('Desactivar transporte?')"><i class="fa-solid fa-trash"></i></button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-8 text-center text-slate-500">No hay transportes registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $transportes->links() }}
</div>
@endsection

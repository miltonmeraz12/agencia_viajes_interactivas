@extends('layouts.app')
@section('title', 'Usuarios')
@section('page-title', 'Usuarios')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="grid gap-4 lg:grid-cols-[1fr_auto]">
        <form method="POST" action="{{ route('usuarios.importar') }}" enctype="multipart/form-data" class="card flex flex-col gap-3 p-4 sm:flex-row sm:items-center">
            @csrf
            <div class="flex-1">
                <p class="font-bold">Importar usuarios desde Excel</p>
                <p class="text-sm text-slate-500">Columnas esperadas: nombre, correo, telefono, fecha_nacimiento.</p>
            </div>
            <input name="archivo" type="file" accept=".xlsx,.csv" class="field sm:max-w-xs" required>
            <button class="btn-primary"><i class="fa-solid fa-upload"></i> Importar</button>
        </form>
        <a href="{{ route('usuarios.exportar') }}" class="btn-light h-fit"><i class="fa-solid fa-file-excel"></i> Exportar Excel</a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500"><tr><th class="p-4">Nombre</th><th class="p-4">Correo</th><th class="p-4">Telefono</th><th class="p-4">Rol</th><th class="p-4 text-right">Acciones</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td class="p-4 font-bold">{{ $usuario->name }}</td>
                            <td class="p-4">{{ $usuario->email }}</td>
                            <td class="p-4">{{ $usuario->phone ?? 'No registrado' }}</td>
                            <td class="p-4">
                                <form method="POST" action="{{ route('usuarios.rol', $usuario) }}" class="flex gap-2">
                                    @csrf @method('PATCH')
                                    <select name="role" class="field !py-2" @disabled($usuario->id === auth()->id())>
                                        <option value="usuario" @selected($usuario->role === 'usuario')>Usuario</option>
                                        <option value="admin" @selected($usuario->role === 'admin')>Admin</option>
                                    </select>
                                    <button class="btn-light !py-2" @disabled($usuario->id === auth()->id())>Guardar</button>
                                </form>
                            </td>
                            <td class="p-4">
                                <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" class="flex justify-end">@csrf @method('DELETE')<button class="btn-light !px-3 text-red-700" onclick="return confirm('Eliminar este usuario?')" @disabled($usuario->id === auth()->id())><i class="fa-solid fa-trash"></i></button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $usuarios->links() }}
</div>
@endsection

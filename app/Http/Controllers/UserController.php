<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        return view('usuarios.index', [
            'usuarios' => User::latest()->paginate(15),
        ]);
    }

    public function exportar()
    {
        return Excel::download(new UsersExport, 'usuarios.xlsx');
    }

    public function importar(Request $request)
    {
        $request->validate(['archivo' => ['required', 'file', 'mimes:xlsx,csv']]);

        $import = new UsersImport();
        Excel::import($import, $request->file('archivo'));

        $errores = collect($import->failures())->map(function ($failure) {
            return 'Fila '.$failure->row().': '.implode(', ', $failure->errors());
        });

        if ($errores->isNotEmpty()) {
            return back()->with('warning', 'Importacion completada con observaciones.')->with('import_errors', $errores);
        }

        return back()->with('success', 'Usuarios importados correctamente.');
    }

    public function actualizarRol(Request $request, User $usuario)
    {
        $data = $request->validate([
            'role' => ['required', 'in:admin,usuario'],
        ]);

        $usuario->update($data);

        return back()->with('success', 'Rol actualizado.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return back()->with('success', 'Usuario eliminado.');
    }
}

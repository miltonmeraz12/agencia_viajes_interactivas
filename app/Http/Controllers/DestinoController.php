<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestinoController extends Controller
{
    public function index(Request $request)
    {
        $query = Destino::query();

        if (! auth()->user()->isAdmin()) {
            $query->where('activo', true);
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('pais', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if ($request->filled('pais')) {
            $query->where('pais', $request->pais);
        }

        if ($request->filled('precio_max')) {
            $query->where('precio_base', '<=', $request->precio_max);
        }

        return view('destinos.index', [
            'destinos' => $query->latest()->paginate(12)->withQueryString(),
            'paises' => Destino::orderBy('pais')->pluck('pais')->unique(),
        ]);
    }

    public function create()
    {
        return view('destinos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['imagenes'] = $this->guardarImagenes($request);
        $data['activo'] = $request->boolean('activo', true);

        Destino::create($data);

        return redirect()->route('destinos.index')->with('success', 'Destino guardado.');
    }

    public function show(Destino $destino)
    {
        $destino->load(['hospedajes', 'viajes.transporte']);

        return view('destinos.show', compact('destino'));
    }

    public function edit(Destino $destino)
    {
        return view('destinos.edit', compact('destino'));
    }

    public function update(Request $request, Destino $destino)
    {
        $data = $request->validate($this->rules());
        $data['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagenes')) {
            foreach ($destino->imagenes ?? [] as $old) {
                Storage::disk('public')->delete($old);
            }
            $data['imagenes'] = $this->guardarImagenes($request);
        }

        $destino->update($data);

        return redirect()->route('destinos.index')->with('success', 'Destino actualizado.');
    }

    public function destroy(Destino $destino)
    {
        $destino->update(['activo' => false]);
        $destino->delete();

        return redirect()->route('destinos.index')->with('success', 'Destino desactivado.');
    }

    private function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'pais' => ['required', 'string', 'max:255'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'precio_base' => ['required', 'numeric', 'min:0'],
            'activo' => ['nullable', 'boolean'],
            'imagenes' => ['nullable', 'array'],
            'imagenes.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    private function guardarImagenes(Request $request): array
    {
        if (! $request->hasFile('imagenes')) {
            return [];
        }

        return collect($request->file('imagenes'))
            ->map(fn ($imagen) => $imagen->store('destinos', 'public'))
            ->all();
    }
}

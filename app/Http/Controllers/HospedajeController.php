<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Hospedaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HospedajeController extends Controller
{
    public function index(Request $request)
    {
        $query = Hospedaje::with('destino');

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('categoria', 'like', "%{$search}%")
                    ->orWhereHas('destino', fn ($d) => $d->where('nombre', 'like', "%{$search}%")->orWhere('pais', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        return view('hospedajes.index', [
            'hospedajes' => $query->latest()->paginate(12)->withQueryString(),
            'categorias' => Hospedaje::orderBy('categoria')->pluck('categoria')->unique(),
        ]);
    }

    public function create()
    {
        return view('hospedajes.create', [
            'destinos' => Destino::where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['imagenes'] = $this->guardarImagenes($request);

        Hospedaje::create($data);

        return redirect()->route('hospedajes.index')->with('success', 'Hospedaje registrado.');
    }

    public function show(Hospedaje $hospedaje)
    {
        $hospedaje->load(['destino', 'viajes.transporte']);

        return view('hospedajes.show', compact('hospedaje'));
    }

    public function edit(Hospedaje $hospedaje)
    {
        return view('hospedajes.edit', [
            'hospedaje' => $hospedaje,
            'destinos' => Destino::where('activo', true)->orderBy('nombre')->get(),
        ]);
    }

    public function update(Request $request, Hospedaje $hospedaje)
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('imagenes')) {
            foreach ($hospedaje->imagenes ?? [] as $old) {
                Storage::disk('public')->delete($old);
            }
            $data['imagenes'] = $this->guardarImagenes($request);
        }

        $hospedaje->update($data);

        return redirect()->route('hospedajes.index')->with('success', 'Hospedaje actualizado.');
    }

    public function destroy(Hospedaje $hospedaje)
    {
        $hospedaje->delete();

        return redirect()->route('hospedajes.index')->with('success', 'Hospedaje desactivado.');
    }

    private function rules(): array
    {
        return [
            'destino_id' => ['required', 'exists:destinos,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'categoria' => ['required', 'string', 'max:100'],
            'precio_noche' => ['required', 'numeric', 'min:0'],
            'habitaciones_disp' => ['required', 'integer', 'min:0'],
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
            ->map(fn ($imagen) => $imagen->store('hospedajes', 'public'))
            ->all();
    }
}

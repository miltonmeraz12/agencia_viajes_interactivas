<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Hospedaje;
use App\Models\Transporte;
use App\Models\Viaje;
use Illuminate\Http\Request;

class ViajeController extends Controller
{
    public function catalogo(Request $request)
    {
        $query = Viaje::with(['destino', 'transporte', 'hospedaje'])
            ->whereDate('fecha_inicio', '>=', now()->toDateString())
            ->whereHas('destino', fn ($q) => $q->where('activo', true));

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhereHas('destino', fn ($d) => $d->where('nombre', 'like', "%{$search}%")->orWhere('pais', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('pais')) {
            $query->whereHas('destino', fn ($q) => $q->where('pais', $request->pais));
        }

        if ($request->filled('precio_max')) {
            $query->where('precio_total', '<=', $request->precio_max);
        }

        $viajes = $query->orderBy('fecha_inicio')->paginate(9)->withQueryString();
        $paises = Destino::where('activo', true)->orderBy('pais')->pluck('pais')->unique();

        return view('viajes.catalogo', compact('viajes', 'paises'));
    }

    public function catalogoShow(Viaje $viaje)
    {
        $viaje->load(['destino.hospedajes', 'hospedaje', 'transporte', 'reservaciones']);

        return view('viajes.catalogo-show', compact('viaje'));
    }

    public function index()
    {
        $viajes = Viaje::with(['destino', 'transporte', 'hospedaje'])
            ->withCount(['reservaciones as reservas_activas_count' => fn ($q) => $q->whereIn('estado', ['pendiente', 'confirmado'])])
            ->latest()
            ->paginate(10);

        return view('viajes.index', compact('viajes'));
    }

    public function create()
    {
        return view('viajes.create', [
            'destinos' => Destino::where('activo', true)->orderBy('nombre')->get(),
            'transportes' => Transporte::orderBy('fecha_salida')->get(),
            'hospedajes' => Hospedaje::with('destino')->orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        Viaje::create($data);

        return redirect()->route('viajes.index')->with('success', 'Paquete de viaje publicado.');
    }

    public function show(Viaje $viaje)
    {
        $viaje->load(['destino', 'hospedaje', 'transporte', 'reservaciones.user']);

        return view('viajes.show', compact('viaje'));
    }

    public function edit(Viaje $viaje)
    {
        return view('viajes.edit', [
            'viaje' => $viaje,
            'destinos' => Destino::orderBy('nombre')->get(),
            'transportes' => Transporte::orderBy('fecha_salida')->get(),
            'hospedajes' => Hospedaje::with('destino')->orderBy('nombre')->get(),
        ]);
    }

    public function update(Request $request, Viaje $viaje)
    {
        $data = $request->validate($this->rules());
        $viaje->update($data);

        return redirect()->route('viajes.index')->with('success', 'Paquete actualizado.');
    }

    public function destroy(Viaje $viaje)
    {
        $viaje->delete();

        return back()->with('success', 'Paquete desactivado.');
    }

    private function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'destino_id' => ['required', 'exists:destinos,id'],
            'transporte_id' => ['required', 'exists:transportes,id'],
            'hospedaje_id' => ['nullable', 'exists:hospedajes,id'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after:fecha_inicio'],
            'precio_total' => ['required', 'numeric', 'min:1'],
            'capacidad' => ['required', 'integer', 'min:1'],
        ];
    }
}

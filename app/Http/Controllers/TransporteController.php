<?php
namespace App\Http\Controllers;

use App\Models\Transporte;
use Illuminate\Http\Request;

class TransporteController extends Controller
{
    public function index()
    {
        $transportes = Transporte::latest()->paginate(10);
        return view('transportes.index', compact('transportes'));
    }

    public function create() { return view('transportes.create'); }

    public function show(Transporte $transporte)
    {
        $transporte->load('viajes.destino');

        return view('transportes.show', compact('transporte'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo'         => 'required|string',
            'origen'       => 'required|string',
            'destino'      => 'required|string',
            'capacidad'    => 'required|integer|min:1',
            'precio'       => 'required|numeric|min:0',
            'fecha_salida' => 'required|date|after:now',
        ]);

        Transporte::create($request->all());
        return redirect()->route('transportes.index')->with('success', 'Ruta de transporte creada.');
    }

    public function edit(Transporte $transporte) { return view('transportes.edit', compact('transporte')); }

    public function update(Request $request, Transporte $transporte)
    {
        $request->validate([
            'tipo'         => 'required|string',
            'origen'       => 'required|string',
            'destino'      => 'required|string',
            'capacidad'    => 'required|integer|min:1',
            'precio'       => 'required|numeric|min:0',
            'fecha_salida' => 'required|date',
        ]);

        $transporte->update($request->all());
        return redirect()->route('transportes.index')->with('success', 'Transporte actualizado.');
    }

    public function destroy(Transporte $transporte)
    {
        $transporte->delete();
        return back()->with('success', 'Transporte eliminado.');
    }
}

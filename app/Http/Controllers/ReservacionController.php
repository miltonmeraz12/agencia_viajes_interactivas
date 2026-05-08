<?php

namespace App\Http\Controllers;

use App\Mail\CompraConfirmadaMail;
use App\Mail\ReservacionCanceladaMail;
use App\Models\Reservacion;
use App\Models\Viaje;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReservacionController extends Controller
{
    public function index()
    {
        $query = Reservacion::with(['user', 'viaje.destino', 'viaje.hospedaje', 'viaje.transporte'])->latest();

        if (! auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        return view('reservaciones.index', [
            'reservaciones' => $query->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'viaje_id' => ['required', 'exists:viajes,id'],
        ]);

        $reservacion = DB::transaction(function () use ($data) {
            $viaje = Viaje::with(['destino', 'hospedaje', 'transporte', 'reservaciones'])->findOrFail($data['viaje_id']);

            if (! $viaje->estaDisponible()) {
                abort(422, 'Este paquete ya no tiene lugares disponibles.');
            }

            return Reservacion::create([
                'user_id' => auth()->id(),
                'viaje_id' => $viaje->id,
                'folio' => $this->folioUnico(),
                'estado' => 'confirmado',
                'monto_pagado' => $viaje->precio_total,
            ]);
        });

        $reservacion->load(['user', 'viaje.destino', 'viaje.hospedaje', 'viaje.transporte']);
        $this->enviarCorreoCompra($reservacion);

        return redirect()->route('reservaciones.show', $reservacion)
            ->with('success', 'Compra registrada. Tu folio es '.$reservacion->folio.'.');
    }

    public function show(Reservacion $reservacion)
    {
        $this->autorizar($reservacion);
        $reservacion->load(['user', 'viaje.destino', 'viaje.hospedaje', 'viaje.transporte']);

        return view('reservaciones.show', compact('reservacion'));
    }

    public function cancelar(Reservacion $reservacion)
    {
        $this->autorizar($reservacion);

        if (in_array($reservacion->estado, ['cancelado', 'completado'], true)) {
            return back()->with('error', 'Esta reservacion ya no puede cancelarse.');
        }

        $reservacion->update(['estado' => 'cancelado']);
        $reservacion->load(['user', 'viaje.destino', 'viaje.hospedaje', 'viaje.transporte']);

        try {
            Mail::to($reservacion->user->email)->send(new ReservacionCanceladaMail($reservacion));
        } catch (\Throwable $exception) {
            Log::warning('No se pudo enviar correo de cancelacion', ['error' => $exception->getMessage()]);
        }

        return back()->with('success', 'Reservacion cancelada. Se notifico al correo registrado.');
    }

    public function descargarTicket(Reservacion $reservacion)
    {
        $this->autorizar($reservacion);
        $reservacion->load(['user', 'viaje.destino', 'viaje.hospedaje', 'viaje.transporte']);

        $pdf = Pdf::loadView('reservaciones.pdf', compact('reservacion'))->setPaper('a4');

        return $pdf->download("ticket-{$reservacion->folio}.pdf");
    }

    public function enviarEmail(Reservacion $reservacion)
    {
        $this->autorizar($reservacion);
        $reservacion->load(['user', 'viaje.destino', 'viaje.hospedaje', 'viaje.transporte']);
        $this->enviarCorreoCompra($reservacion);

        return back()->with('success', 'Correo de confirmacion reenviado.');
    }

    private function autorizar(Reservacion $reservacion): void
    {
        if (! auth()->user()->isAdmin() && $reservacion->user_id !== auth()->id()) {
            abort(403);
        }
    }

    private function folioUnico(): string
    {
        do {
            $folio = strtoupper(Str::random(8));
        } while (Reservacion::where('folio', $folio)->exists());

        return $folio;
    }

    private function enviarCorreoCompra(Reservacion $reservacion): void
    {
        try {
            Mail::to($reservacion->user->email)->send(new CompraConfirmadaMail($reservacion));
        } catch (\Throwable $exception) {
            Log::warning('No se pudo enviar correo de compra', ['error' => $exception->getMessage()]);
        }
    }
}

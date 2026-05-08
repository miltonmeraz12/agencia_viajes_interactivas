<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Reservacion;
use App\Models\User;
use App\Models\Viaje;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $ventasPorMes = Reservacion::query()
                ->whereYear('created_at', now()->year)
                ->get()
                ->groupBy(fn (Reservacion $reservacion) => (int) $reservacion->created_at->format('n'))
                ->map->count();

            return view('dashboard', [
                'totalReservas' => Reservacion::count(),
                'totalPaquetes' => Viaje::count(),
                'totalDestinos' => Destino::count(),
                'totalUsuarios' => User::where('role', 'usuario')->count(),
                'ingresos' => Reservacion::whereIn('estado', ['confirmado', 'completado'])->sum('monto_pagado'),
                'meses' => collect(range(1, 12))->map(fn ($m) => $ventasPorMes->get($m, 0)),
                'estadosReserva' => collect([
                    Reservacion::where('estado', 'confirmado')->count(),
                    Reservacion::where('estado', 'pendiente')->count(),
                    Reservacion::where('estado', 'cancelado')->count(),
                ]),
                'reservacionesRecientes' => Reservacion::with(['user', 'viaje.destino'])->latest()->take(6)->get(),
            ]);
        }

        return view('dashboard', [
            'misReservasCount' => $user->reservaciones()->count(),
            'misUltimasReservas' => $user->reservaciones()
                ->with(['viaje.destino', 'viaje.hospedaje', 'viaje.transporte'])
                ->latest()
                ->take(3)
                ->get(),
            'paquetesDestacados' => Viaje::with(['destino', 'hospedaje', 'transporte'])
                ->whereDate('fecha_inicio', '>=', now()->toDateString())
                ->latest()
                ->take(3)
                ->get(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Destino;
use App\Models\Hospedaje;
use App\Models\Reservacion;
use App\Models\Transporte;
use App\Models\User;
use App\Models\Viaje;
use Illuminate\Database\Seeder;

class TravelCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $destinos = $this->seedDestinos();
        $hospedajes = $this->seedHospedajes($destinos);
        $transportes = $this->seedTransportes();
        $viajes = $this->seedViajes($destinos, $hospedajes, $transportes);
        $this->seedReservaciones($viajes);
    }

    private function seedDestinos(): array
    {
        $items = [
            'Cancun' => [
                'pais' => 'Mexico',
                'direccion' => 'Zona Hotelera, Quintana Roo',
                'descripcion' => 'Playas de arena clara, arrecifes, parques acuaticos, vida nocturna y salidas a Isla Mujeres. Ideal para escapadas de descanso, lunas de miel y vacaciones familiares con actividades todos los dias.',
                'precio_base' => 5200,
            ],
            'Oaxaca Colonial' => [
                'pais' => 'Mexico',
                'direccion' => 'Centro Historico, Oaxaca',
                'descripcion' => 'Ruta cultural con gastronomia regional, mercados, talleres artesanales, Monte Alban y calles coloniales. Pensado para viajeros que buscan historia, comida local y experiencias guiadas.',
                'precio_base' => 3600,
            ],
            'Paris Esencial' => [
                'pais' => 'Francia',
                'direccion' => 'Centro de Paris',
                'descripcion' => 'Museos, Torre Eiffel, paseos por el Sena, barrios historicos y experiencias gastronomicas. Un paquete urbano para primera visita con tiempo libre y tours sugeridos.',
                'precio_base' => 28500,
            ],
            'Nueva York Express' => [
                'pais' => 'Estados Unidos',
                'direccion' => 'Manhattan, Nueva York',
                'descripcion' => 'Escapada de ciudad con Times Square, Central Park, miradores, museos y compras. Recomendado para viajeros que quieren una agenda dinamica y transporte practico.',
                'precio_base' => 19800,
            ],
            'Riviera Maya Familiar' => [
                'pais' => 'Mexico',
                'direccion' => 'Playa del Carmen, Quintana Roo',
                'descripcion' => 'Playas tranquilas, cenotes, parques tematicos y hoteles con actividades para todas las edades. Perfecto para familias o grupos que quieren equilibrar descanso y aventura.',
                'precio_base' => 6400,
            ],
            'Tokio Moderno' => [
                'pais' => 'Japon',
                'direccion' => 'Shinjuku, Tokio',
                'descripcion' => 'Tecnologia, templos, gastronomia, barrios neon y trenes metropolitanos. El paquete combina recorridos urbanos con dias libres para explorar cultura pop y mercados.',
                'precio_base' => 41200,
            ],
            'Bariloche Naturaleza' => [
                'pais' => 'Argentina',
                'direccion' => 'San Carlos de Bariloche, Rio Negro',
                'descripcion' => 'Lagos, montanas, chocolate artesanal, senderismo y miradores panoramicos. Una experiencia de naturaleza fresca con hospedajes comodos y traslados incluidos.',
                'precio_base' => 22400,
            ],
            'Madrid Historico' => [
                'pais' => 'Espana',
                'direccion' => 'Gran Via, Madrid',
                'descripcion' => 'Museos, plazas, tapas, arquitectura historica y conexiones faciles a Toledo o Segovia. Ideal para conocer Europa con una ciudad caminable y llena de cultura.',
                'precio_base' => 24800,
            ],
        ];

        $destinos = [];
        foreach ($items as $nombre => $data) {
            $destinos[$nombre] = Destino::updateOrCreate(
                ['nombre' => $nombre],
                array_merge($data, ['activo' => true, 'imagenes' => []])
            );
        }

        return $destinos;
    }

    private function seedHospedajes(array $destinos): array
    {
        $items = [
            'Marina Azul Resort' => ['destino' => 'Cancun', 'direccion' => 'Boulevard Kukulcan km 12.5', 'categoria' => 'resort', 'precio_noche' => 2400, 'habitaciones_disp' => 25],
            'Bahia Coral Hotel' => ['destino' => 'Cancun', 'direccion' => 'Punta Cancun', 'categoria' => 'hotel', 'precio_noche' => 1650, 'habitaciones_disp' => 34],
            'Casa Nube Hotel' => ['destino' => 'Oaxaca Colonial', 'direccion' => 'Centro Historico', 'categoria' => 'hotel', 'precio_noche' => 1350, 'habitaciones_disp' => 18],
            'Hostal Mezcal Patio' => ['destino' => 'Oaxaca Colonial', 'direccion' => 'Barrio de Jalatlaco', 'categoria' => 'hostal', 'precio_noche' => 620, 'habitaciones_disp' => 22],
            'Rive Gauche Boutique' => ['destino' => 'Paris Esencial', 'direccion' => 'Quartier Latin', 'categoria' => 'hotel', 'precio_noche' => 3900, 'habitaciones_disp' => 12],
            'Montmartre Lumiere' => ['destino' => 'Paris Esencial', 'direccion' => 'Montmartre', 'categoria' => 'hotel', 'precio_noche' => 3200, 'habitaciones_disp' => 16],
            'Midtown Hub Hotel' => ['destino' => 'Nueva York Express', 'direccion' => 'West 39th Street', 'categoria' => 'hotel', 'precio_noche' => 4100, 'habitaciones_disp' => 20],
            'Brooklyn Loft Stay' => ['destino' => 'Nueva York Express', 'direccion' => 'Williamsburg', 'categoria' => 'hostal', 'precio_noche' => 2100, 'habitaciones_disp' => 15],
            'Selva Azul Family Resort' => ['destino' => 'Riviera Maya Familiar', 'direccion' => 'Carretera Federal Tulum', 'categoria' => 'resort', 'precio_noche' => 2850, 'habitaciones_disp' => 28],
            'Cenote Garden Hotel' => ['destino' => 'Riviera Maya Familiar', 'direccion' => 'Playa del Carmen Centro', 'categoria' => 'hotel', 'precio_noche' => 1850, 'habitaciones_disp' => 24],
            'Shinjuku Urban Inn' => ['destino' => 'Tokio Moderno', 'direccion' => 'Shinjuku-ku', 'categoria' => 'hotel', 'precio_noche' => 4700, 'habitaciones_disp' => 14],
            'Asakusa Capsule House' => ['destino' => 'Tokio Moderno', 'direccion' => 'Asakusa', 'categoria' => 'hostal', 'precio_noche' => 1500, 'habitaciones_disp' => 32],
            'Lago Moreno Lodge' => ['destino' => 'Bariloche Naturaleza', 'direccion' => 'Circuito Chico', 'categoria' => 'hotel', 'precio_noche' => 2600, 'habitaciones_disp' => 18],
            'Gran Via Central' => ['destino' => 'Madrid Historico', 'direccion' => 'Gran Via 42', 'categoria' => 'hotel', 'precio_noche' => 3100, 'habitaciones_disp' => 19],
        ];

        $hospedajes = [];
        foreach ($items as $nombre => $data) {
            $hospedajes[$nombre] = Hospedaje::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'destino_id' => $destinos[$data['destino']]->id,
                    'direccion' => $data['direccion'],
                    'categoria' => $data['categoria'],
                    'precio_noche' => $data['precio_noche'],
                    'habitaciones_disp' => $data['habitaciones_disp'],
                    'imagenes' => [],
                ]
            );
        }

        return $hospedajes;
    }

    private function seedTransportes(): array
    {
        $items = [
            'Bus Oaxaca Matutino' => ['tipo' => 'Autobus', 'origen' => 'San Luis Potosi', 'destino' => 'Oaxaca', 'capacidad' => 42, 'precio' => 900, 'fecha_salida' => now()->addDays(12)->setTime(7, 30)],
            'Vuelo Cancun Directo' => ['tipo' => 'Avion', 'origen' => 'Ciudad de Mexico', 'destino' => 'Cancun', 'capacidad' => 120, 'precio' => 2600, 'fecha_salida' => now()->addDays(18)->setTime(9, 0)],
            'Vuelo Paris Nocturno' => ['tipo' => 'Avion', 'origen' => 'Ciudad de Mexico', 'destino' => 'Paris', 'capacidad' => 180, 'precio' => 14200, 'fecha_salida' => now()->addDays(35)->setTime(22, 15)],
            'Vuelo Nueva York' => ['tipo' => 'Avion', 'origen' => 'Ciudad de Mexico', 'destino' => 'Nueva York', 'capacidad' => 160, 'precio' => 7600, 'fecha_salida' => now()->addDays(24)->setTime(6, 45)],
            'Van Riviera Maya' => ['tipo' => 'Autobus', 'origen' => 'Cancun', 'destino' => 'Playa del Carmen', 'capacidad' => 28, 'precio' => 450, 'fecha_salida' => now()->addDays(20)->setTime(11, 0)],
            'Vuelo Tokio Conexion' => ['tipo' => 'Avion', 'origen' => 'Ciudad de Mexico', 'destino' => 'Tokio', 'capacidad' => 210, 'precio' => 22300, 'fecha_salida' => now()->addDays(48)->setTime(1, 20)],
            'Vuelo Bariloche' => ['tipo' => 'Avion', 'origen' => 'Ciudad de Mexico', 'destino' => 'Bariloche', 'capacidad' => 130, 'precio' => 11800, 'fecha_salida' => now()->addDays(32)->setTime(18, 10)],
            'Vuelo Madrid' => ['tipo' => 'Avion', 'origen' => 'Ciudad de Mexico', 'destino' => 'Madrid', 'capacidad' => 190, 'precio' => 13200, 'fecha_salida' => now()->addDays(40)->setTime(23, 0)],
            'Tren Madrid Toledo' => ['tipo' => 'Tren', 'origen' => 'Madrid', 'destino' => 'Toledo', 'capacidad' => 90, 'precio' => 780, 'fecha_salida' => now()->addDays(42)->setTime(8, 15)],
            'Barco Isla Mujeres' => ['tipo' => 'Barco', 'origen' => 'Cancun', 'destino' => 'Isla Mujeres', 'capacidad' => 70, 'precio' => 520, 'fecha_salida' => now()->addDays(19)->setTime(10, 30)],
        ];

        $transportes = [];
        foreach ($items as $nombre => $data) {
            $transportes[$nombre] = Transporte::updateOrCreate(
                ['tipo' => $data['tipo'], 'origen' => $data['origen'], 'destino' => $data['destino']],
                [
                    'capacidad' => $data['capacidad'],
                    'precio' => $data['precio'],
                    'fecha_salida' => $data['fecha_salida'],
                ]
            );
        }

        return $transportes;
    }

    private function seedViajes(array $destinos, array $hospedajes, array $transportes): array
    {
        $items = [
            'Caribe Todo Incluido' => ['destino' => 'Cancun', 'hospedaje' => 'Marina Azul Resort', 'transporte' => 'Vuelo Cancun Directo', 'inicio' => 18, 'fin' => 23, 'precio' => 18500, 'capacidad' => 30],
            'Cancun Escapada Isla Mujeres' => ['destino' => 'Cancun', 'hospedaje' => 'Bahia Coral Hotel', 'transporte' => 'Barco Isla Mujeres', 'inicio' => 19, 'fin' => 22, 'precio' => 12400, 'capacidad' => 24],
            'Oaxaca Cultural' => ['destino' => 'Oaxaca Colonial', 'hospedaje' => 'Casa Nube Hotel', 'transporte' => 'Bus Oaxaca Matutino', 'inicio' => 12, 'fin' => 16, 'precio' => 7900, 'capacidad' => 20],
            'Oaxaca Sabores y Talleres' => ['destino' => 'Oaxaca Colonial', 'hospedaje' => 'Hostal Mezcal Patio', 'transporte' => 'Bus Oaxaca Matutino', 'inicio' => 26, 'fin' => 29, 'precio' => 5200, 'capacidad' => 18],
            'Paris Primera Visita' => ['destino' => 'Paris Esencial', 'hospedaje' => 'Rive Gauche Boutique', 'transporte' => 'Vuelo Paris Nocturno', 'inicio' => 35, 'fin' => 42, 'precio' => 58900, 'capacidad' => 14],
            'Paris Museos y Sena' => ['destino' => 'Paris Esencial', 'hospedaje' => 'Montmartre Lumiere', 'transporte' => 'Vuelo Paris Nocturno', 'inicio' => 52, 'fin' => 58, 'precio' => 54800, 'capacidad' => 16],
            'Nueva York Express 5 Dias' => ['destino' => 'Nueva York Express', 'hospedaje' => 'Midtown Hub Hotel', 'transporte' => 'Vuelo Nueva York', 'inicio' => 24, 'fin' => 29, 'precio' => 36200, 'capacidad' => 22],
            'Riviera Maya Familiar' => ['destino' => 'Riviera Maya Familiar', 'hospedaje' => 'Selva Azul Family Resort', 'transporte' => 'Van Riviera Maya', 'inicio' => 20, 'fin' => 26, 'precio' => 21800, 'capacidad' => 26],
            'Riviera Maya Cenotes' => ['destino' => 'Riviera Maya Familiar', 'hospedaje' => 'Cenote Garden Hotel', 'transporte' => 'Van Riviera Maya', 'inicio' => 31, 'fin' => 35, 'precio' => 15600, 'capacidad' => 20],
            'Tokio Moderno y Tradicional' => ['destino' => 'Tokio Moderno', 'hospedaje' => 'Shinjuku Urban Inn', 'transporte' => 'Vuelo Tokio Conexion', 'inicio' => 48, 'fin' => 58, 'precio' => 74900, 'capacidad' => 12],
            'Bariloche Lagos y Montanas' => ['destino' => 'Bariloche Naturaleza', 'hospedaje' => 'Lago Moreno Lodge', 'transporte' => 'Vuelo Bariloche', 'inicio' => 32, 'fin' => 39, 'precio' => 43900, 'capacidad' => 18],
            'Madrid Historico con Toledo' => ['destino' => 'Madrid Historico', 'hospedaje' => 'Gran Via Central', 'transporte' => 'Vuelo Madrid', 'inicio' => 40, 'fin' => 47, 'precio' => 49800, 'capacidad' => 20],
        ];

        $viajes = [];
        foreach ($items as $nombre => $data) {
            $viajes[$nombre] = Viaje::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'destino_id' => $destinos[$data['destino']]->id,
                    'hospedaje_id' => $hospedajes[$data['hospedaje']]->id,
                    'transporte_id' => $transportes[$data['transporte']]->id,
                    'fecha_inicio' => now()->addDays($data['inicio'])->toDateString(),
                    'fecha_fin' => now()->addDays($data['fin'])->toDateString(),
                    'precio_total' => $data['precio'],
                    'capacidad' => $data['capacidad'],
                ]
            );
        }

        return $viajes;
    }

    private function seedReservaciones(array $viajes): void
    {
        $items = [
            ['email' => 'usuario@agencia.com', 'viaje' => 'Caribe Todo Incluido', 'folio' => 'AVC10001', 'estado' => 'confirmado'],
            ['email' => 'ana.torres@example.com', 'viaje' => 'Oaxaca Cultural', 'folio' => 'AVC10002', 'estado' => 'confirmado'],
            ['email' => 'luis.mendoza@example.com', 'viaje' => 'Nueva York Express 5 Dias', 'folio' => 'AVC10003', 'estado' => 'pendiente'],
            ['email' => 'mariana.ruiz@example.com', 'viaje' => 'Paris Primera Visita', 'folio' => 'AVC10004', 'estado' => 'cancelado'],
            ['email' => 'usuario@agencia.com', 'viaje' => 'Riviera Maya Familiar', 'folio' => 'AVC10005', 'estado' => 'confirmado'],
        ];

        foreach ($items as $data) {
            $user = User::where('email', $data['email'])->first();
            $viaje = $viajes[$data['viaje']] ?? null;

            if (! $user || ! $viaje) {
                continue;
            }

            Reservacion::updateOrCreate(
                ['folio' => $data['folio']],
                [
                    'user_id' => $user->id,
                    'viaje_id' => $viaje->id,
                    'estado' => $data['estado'],
                    'monto_pagado' => $viaje->precio_total,
                ]
            );
        }
    }
}

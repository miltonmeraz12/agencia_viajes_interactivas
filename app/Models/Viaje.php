<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Viaje extends Model
{
    use SoftDeletes; // Útil para desactivar paquetes viejos

    protected $table = 'viajes';
    
    protected $fillable = [
        'destino_id', 
        'hospedaje_id', 
        'transporte_id', 
        'nombre', 
        'fecha_inicio', 
        'fecha_fin', 
        'precio_total', 
        'capacidad'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'precio_total' => 'decimal:2',
        'capacidad' => 'integer',
    ];

    public function destino()   { return $this->belongsTo(Destino::class); }
    public function transporte(){ return $this->belongsTo(Transporte::class); }
    public function hospedaje() { return $this->belongsTo(Hospedaje::class); }
    public function reservaciones(){ return $this->hasMany(Reservacion::class); }

    public function reservacionesActivas()
    {
        return $this->reservaciones()->whereIn('estado', ['pendiente', 'confirmado']);
    }

    public function lugaresDisponibles(): int
    {
        return max(0, $this->capacidad - $this->reservacionesActivas()->count());
    }

    public function estaDisponible(): bool
    {
        return $this->lugaresDisponibles() > 0
            && $this->fecha_inicio->greaterThanOrEqualTo(now()->startOfDay());
    }
}

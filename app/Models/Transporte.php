<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transporte extends Model
{
    use SoftDeletes;
    
    protected $table = 'transportes';
    
    protected $fillable = [
        'tipo', 
        'origen', 
        'destino', 
        'capacidad', 
        'precio', 
        'fecha_salida'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'fecha_salida' => 'datetime',
        'capacidad' => 'integer',
    ];

    public function viajes() { return $this->hasMany(Viaje::class); }

    public function reservacionesActivas()
    {
        return $this->hasManyThrough(Reservacion::class, Viaje::class)
            ->whereIn('reservaciones.estado', ['pendiente', 'confirmado']);
    }

    public function lugaresDisponibles(): int
    {
        return max(0, $this->capacidad - $this->reservacionesActivas()->count());
    }
}

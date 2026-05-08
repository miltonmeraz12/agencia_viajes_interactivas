<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospedaje extends Model
{
    use SoftDeletes;
    
    protected $table = 'hospedajes';
    
    protected $fillable = [
        'destino_id', 
        'nombre',
        'direccion',
        'categoria', 
        'precio_noche', 
        'habitaciones_disp', 
        'imagenes'
    ];
    
    protected $casts = [
        'imagenes' => 'array',
        'precio_noche' => 'decimal:2',
        'habitaciones_disp' => 'integer',
    ];

    public function destino() { return $this->belongsTo(Destino::class); }
    public function viajes() { return $this->hasMany(Viaje::class); }

    public function imagenPrincipal(): ?string
    {
        return $this->imagenes[0] ?? null;
    }
}

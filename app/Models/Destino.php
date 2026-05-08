<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destino extends Model
{
    use SoftDeletes;

    protected $table = 'destinos';
    
    protected $fillable = [
        'nombre', 
        'pais', 
        'direccion',
        'descripcion', 
        'precio_base', 
        'activo', 
        'imagenes'
    ];
    
    protected $casts = [
        'imagenes' => 'array',
        'activo' => 'boolean',
        'precio_base' => 'decimal:2',
    ];

    public function hospedajes() { return $this->hasMany(Hospedaje::class); }
    public function viajes() { return $this->hasMany(Viaje::class); }

    public function imagenPrincipal(): ?string
    {
        return $this->imagenes[0] ?? null;
    }
}

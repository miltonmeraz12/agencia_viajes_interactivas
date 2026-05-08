<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destino_id')->constrained('destinos')->onDelete('cascade');
            $table->foreignId('transporte_id')->constrained('transportes')->onDelete('cascade');
            $table->foreignId('hospedaje_id')->nullable()->constrained('hospedajes')->onDelete('set null');
            $table->string('nombre'); // Ej: "Escapada a Cancún"
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->decimal('precio_total', 10, 2);
            $table->integer('capacidad');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
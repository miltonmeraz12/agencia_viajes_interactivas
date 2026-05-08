<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transportes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // bus, avion, tren
            $table->string('origen');
            $table->string('destino');
            $table->integer('capacidad');
            $table->decimal('precio', 10, 2);
            $table->datetime('fecha_salida');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transportes');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospedajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destino_id')->constrained('destinos')->onDelete('cascade');
            $table->string('nombre');
            $table->string('direccion')->nullable(); 
            $table->string('categoria'); 
            $table->decimal('precio_noche', 10, 2);
            $table->integer('habitaciones_disp');
            $table->json('imagenes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospedajes');
    }
};
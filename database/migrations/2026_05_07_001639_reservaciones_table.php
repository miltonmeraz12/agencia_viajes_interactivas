<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('viaje_id')->constrained('viajes')->onDelete('cascade');
            $table->string('folio')->unique(); // RF-27: Alfanumérico 8 caracteres
            $table->enum('estado', ['pendiente', 'confirmado', 'completado', 'cancelado'])->default('pendiente');
            $table->decimal('monto_pagado', 10, 2);
            $table->timestamps(); // Incluye created_at solicitado
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservaciones');
    }
};
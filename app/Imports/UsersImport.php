<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts, WithChunkReading
{
    use SkipsFailures;

    public function model(array $row)
    {
        return new User([
            'name' => $row['nombre'],
            'email' => $row['correo'],
            'phone' => $row['telefono'] ?? null,
            'birth_date' => $row['fecha_nacimiento'] ?? null,
            'password' => Hash::make('password123'),
            'role' => 'usuario',
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'email', 'unique:users,email'],
            'telefono' => ['nullable', 'max:30'],
            'fecha_nacimiento' => ['nullable', 'date'],
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Test',
                'email' => 'admin@agencia.com',
                'phone' => '4441000001',
                'birth_date' => '1990-01-15',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Usuario Test',
                'email' => 'usuario@agencia.com',
                'phone' => '4441000002',
                'birth_date' => '1998-06-21',
                'role' => 'usuario',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Ana Torres',
                'email' => 'ana.torres@example.com',
                'phone' => '4442101122',
                'birth_date' => '1996-03-08',
                'role' => 'usuario',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Luis Mendoza',
                'email' => 'luis.mendoza@example.com',
                'phone' => '4442203344',
                'birth_date' => '1988-11-19',
                'role' => 'usuario',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Mariana Ruiz',
                'email' => 'mariana.ruiz@example.com',
                'phone' => '4442305566',
                'birth_date' => '2001-09-27',
                'role' => 'usuario',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}

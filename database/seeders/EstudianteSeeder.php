<?php

namespace Database\Seeders;

use App\Models\ItEstudiante;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario = User::create([
            'us_correo' => 'juan@estudiante.com',
            'us_password' => bcrypt('juan123'),
            'us_tipo' => '0',
            'us_created' => now(),
        ]);

        $docente = ItEstudiante::create([
            'es_documento' => '1234567',
            'es_nombre' => 'jacob',
            'es_apellido' => 'ricaldi',
            'es_correo' => $usuario->us_correo,
            'es_nacimiento' => '1994-02-03',
            'es_genero' => 1,
            'es_created' => now()->format('Y-m-d H:s:i'),
            'us_codigo_create' => '412',
            'us_codigo' => $usuario->us_codigo,
        ]);
    }
}
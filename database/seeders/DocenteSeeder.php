<?php

namespace Database\Seeders;

use App\Models\ItDocente;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*$usuario = User::create([
            'us_correo' => 'docente@docente.com',
            'us_password' => bcrypt('docente123'),
            'us_tipo' => '1',
            'us_created' => now(),
        ]);*/

        $docente = ItDocente::create([
            'do_documento' => '1234567',
            'do_nombre' => 'jacob',
            'do_apellido' => 'ricaldi',
            'do_correo' => 'docente@docente',
            'do_nacimiento' => '1994-02-03',
            'do_genero' => 1,
            'do_created' => now()->format('Y-m-d H:s:i'),
            'us_codigo_create' => '412',
            'us_codigo' => 434,
        ]);
    }
}
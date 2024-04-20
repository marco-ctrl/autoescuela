<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'us_correo' => 'admin@admin.com',
            'us_password' => bcrypt('admin123'),
            'us_tipo' => '3',
            'us_created' => now(),
        ]);
    }
}

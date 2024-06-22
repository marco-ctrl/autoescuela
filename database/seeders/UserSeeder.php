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
        /*User::create([
            'us_correo' => 'admin@admin.com',
            'us_password' => bcrypt('admin123'),
            'us_tipo' => '3',
            'us_created' => now(),
        ]);*/

        User::create([
            'us_correo' => 'manager@manager.com',
            'us_password' => bcrypt('manager123'),
            'us_tipo' => '2',
            'us_created' => now(),
        ]);
    }
}

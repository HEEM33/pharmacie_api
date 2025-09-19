<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création d’un pharmacien par défaut
        $pharmacienUser = User::firstOrCreate(
            ['email' => 'pharmacien@pharma.com'],
            [
                'name' => 'Pharmacien Test',
                'password' => Hash::make('12345678'),
            ]
        );
        $pharmacienUser->assignRole('pharmacien');

        // Création d’un caissier par défaut
        $caissierUser = User::firstOrCreate(
            ['email' => 'caissier@pharma.com'],
            [
                'name' => 'Caissier Test',
                'password' => Hash::make('12345678'),
            ]
        );
        $caissierUser->assignRole('caissier');
    }
}

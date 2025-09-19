<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = Role::create(['name' => 'admin']);
    $admin->givePermissionTo(Permission::all());
     $pharmacien = Role::create(['name' => 'pharmacien']);
      $caissier = Role::create(['name' => 'caissier']);

 $this->call(UserSeeder::class);
      
    }
}



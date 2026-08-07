<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

    class DatabaseSeeder extends Seeder
    {
        /**
         * Seed the application's database.
         */
        public function run(): void
        {
        
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'cpf' => '12345678900',
                'password' => Hash::make('password'),
                'role' => 'admin', 
            ]);
            User::factory()->create([
                'name' => 'User',
                'email' => 'user@example.com',
                'cpf' => '00987654321',
                'password' => Hash::make('123'),
                'role' => 'user', 
            ]);

            Product::factory(7)->create();
        }
}

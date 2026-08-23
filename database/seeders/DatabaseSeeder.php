<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
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
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'cpf' => '12345678900',
                'password' => Hash::make('password'),
                'role' => 'admin', 
                'photo' => 'images/admin.png',
            ]);
            User::factory()->create([
                'name' => 'User1',
                'email' => 'user1@example.com',
                'cpf' => '00987654321',
                'password' => Hash::make('123'),
                'role' => 'user', 
                'photo' => 'images/user1.jpg',
            ]);
            User::factory()->create([
                'name' => 'User2',
                'email' => 'user2@example.com',
                'cpf' => '67854321312',
                'password' => Hash::make('123'),
                'role' => 'user', 
                'photo' => 'images/user2.png',
            ]);
            Product::factory(15)->create();

            Address::factory()->create(['user_id' => 1]);
            Address::factory()->create(['user_id' => 2]);
            Address::factory()->create(['user_id' => 3]);

            Order::factory(5)->create();
            OrderItem::factory(8)->create();
        }
}

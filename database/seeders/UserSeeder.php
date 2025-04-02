<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем администратора
        DB::table('users')->insert([
            'login' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Создаем контент-менеджера
        DB::table('users')->insert([
            'login' => 'manager',
            'password' => Hash::make('password'),
            'role' => 'content_manager',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Создаем обычного пользователя
        DB::table('users')->insert([
            'login' => 'user',
            'password' => Hash::make('password'),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

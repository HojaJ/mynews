<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = ['Admin', 'John', 'Alice'];
        
        for ($i = 1; $i <= 12; $i++) {
            DB::table('news')->insert([
                'name' => 'Новость ' . $i,
                'description' => 'Описание новости ' . $i . '. Здесь может быть ваш текст.',
                'image' => 'images/news.jpg',
                'author' => $authors[array_rand($authors)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

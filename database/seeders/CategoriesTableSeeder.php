<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "name" => "High-Tech",
            "slug" => "High-Tech",
        ]);
        Category::create([
            "name" => "Livres",
            "slug" => "Livres-Tech",
        ]);
        Category::create([
            "name" => "Meubles",
            "slug" => "meubles",
        ]);
        Category::create([
            "name" => "Jeux",
            "slug" => "jeux",
        ]);
        Category::create([
            "name" => "Nourriture",
            "slug" => "nourriture",
        ]);
        Category::create([
            "name" => "Informatique",
            "slug" => "informatique",
        ]);
    }
}

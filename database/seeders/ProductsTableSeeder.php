<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Product;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        
        $faker = Faker::create();
        foreach(range(1, 15) as $index){
            Product::create([
                'title' => $faker->sentence(4),
                'slug' => $faker->slug,
                'subtitle' => $faker->sentence(8),
                'description' => $faker->text,
                'price' => $faker->numberBetween(15, 300)*100,
                'image' => 'https://via.placeholder.com/200x250'
    
            ])->categories()->attach([
                rand(1, 4),
                rand(1, 4)
            ]);

        }
        // Product::create([
        //     'title' => "Sample thes posts",
        //     'slug' => "dsz-sddfs-6eaeb6",
        //     'subtitle' => "This blogs post shows a few different types of content that’s supported and styled with Bootstrap.",
        //     'description' => "This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, images, and code are all supported.",
        //     'price' => 9000,
        //     'image' => 'https://via.placeholder.com/200x250'

        // ])->categories()->attach([
        //     rand(1, 4),
        //     rand(1, 4)
        // ]);
    }
}

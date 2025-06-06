<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categoryIds = DB::table("category")->pluck("id")->toArray();

        if(empty($categoryIds)){
            $this->command->warn("no hay categorias en la tabla category");
            return;
        }

        $product = [];
        for ($i = 1; $i <= 10; $i++) {
            $product[] = [
                'name' => $faker->word . " $i",
                'description' => $faker->sentence(10),
                'price' => $faker->randomFloat(2, 10, 100), // Random price between 1 and 100
                'category_id' => $faker->randomElement($categoryIds),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table("product")->insert($product);
    }
}

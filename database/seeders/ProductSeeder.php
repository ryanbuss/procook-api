<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Truncate existing records to start from scratch
        Product::truncate();

        $faker = Factory::create();

        for($i = 0; $i < 10; $i++)
        {
            Product::create([
                'product_name' => "Product ".($i + 1),
                'product_desc' => "This is product ".($i + 1),
                'product_category' => "Category ".random_int(1, 10),
                'product_price' => ($faker->numberBetween(0, 99999) / 100),
            ]);
        }
    }
}

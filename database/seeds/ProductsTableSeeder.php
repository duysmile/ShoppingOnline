<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $count = 100;
        for ($i = 0; $i < $count; $i++) {
//            try{
            $name = $faker->words('5', true);
            $price = $faker->numberBetween(800, 5000);
            \App\Model\Product::create([
                'name' => $name,
                'slug' => str_slug($name),
                'price' => $price,
                'quantity' => $faker->numberBetween(5, 50),
                'description' => $faker->paragraph(20, true),
                'summary' => $faker->sentence(10),
                'views' => $faker->numberBetween(0, 1000),
                'standard_price' => $price + $faker->numberBetween(0, 50) * $price / 100,
                'is_approved' => $faker->numberBetween(0, 1) == 1,
                'created_user' => 2,
            ]);

            $product = \App\Model\Product::orderBy('id', 'desc')->first();
            \App\Model\Image::create([
                'url' => asset('images/seed'). '/' . ($i % 20 + 1) . '.jpg',
                'product_id' => $product->id,
                'created_user' => 2
            ]);
            $category = \App\Model\Category::find($faker->numberBetween(1, 9));
            $product->categories()->attach($category);
            if ($category->parent_id != null) {
                $product->categories()->attach(\App\Model\Category::find($category->parent_id));
            }
        }
    }
}

<?php

namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();

        $name = $faker->words;
        $nameString = implode(' ', $name);
        $category = rand(1,2);
        $names = Categories::find($category);
        return [
            'product_name'  => $names->category_name.' '.$nameString,
            'product_slug'  => Str::slug($nameString),
            'id_category'   => $category,
            'price'         => rand(10000,1000000),
            'description'   => fake()->paragraph(),
            'tags'          => '',
            'images'        => 'http://placehold.it/250x350',
            'brand_id'     => 1
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SpecialProduct>
 */
class SpecialProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_product' => rand(1,50),
            'disc'      => rand(1,30),
            'final_amount'=> rand(40000,70000),
            'status'=>1
        ];
    }
}

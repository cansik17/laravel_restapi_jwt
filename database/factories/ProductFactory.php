<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(33),
            'description' => $this->faker->text(200),
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 500),
           
        ];
    }
}

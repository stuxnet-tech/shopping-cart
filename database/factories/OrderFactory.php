<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Order;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->word(),
            'status' => $this->faker->randomElement(["pending","processing","completed","canceled"]),
            'total_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'items' => $this->faker->word(),
        ];
    }
}

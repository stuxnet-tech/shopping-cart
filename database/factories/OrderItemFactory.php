<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\OrderItem;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_id' => $this->faker->word(),
            'product_id' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'price' => $this->faker->randomFloat(2, 0, 99999999.99),
        ];
    }
}

<?php

namespace A21ns1g4ts\FilamentShop\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function modelName()
    {
        return config('filament-shop.products.model');
    }

    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->unique()->words(3, true),
            'meta' => ['foo' => 'bar'],
            'slug' => Str::slug($name),
            'sku' => $this->faker->unique()->ean8(),
            'barcode' => $this->faker->ean13(),
            'description' => $this->faker->realText(),
            'quantity' => $this->faker->randomDigitNotNull(),
            'security_stock' => $this->faker->randomDigitNotNull(),
            'pinned' => $this->faker->boolean(),
            'visible' => $this->faker->boolean(),
            'original_price' => $this->faker->randomFloat(2, 100, 500),
            'price' => $this->faker->randomFloat(2, 80, 400),
            'cost' => $this->faker->randomFloat(2, 50, 200),
            'published_at' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}

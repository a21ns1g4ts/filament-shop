<?php

namespace A21ns1g4ts\FilamentShop\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function modelName()
    {
        return config('filament-shop.categories.model');
    }

    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->unique()->words(3, true),
            'slug' => Str::slug($name),
            'description' => $this->faker->realText(),
            'visible' => $this->faker->boolean(),
            'active' => $this->faker->boolean(),
            'sort' => $this->faker->randomNumber(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}

<?php

namespace A21ns1g4ts\FilamentShop\Database\Factories;

use A21ns1g4ts\FilamentShop\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->unique()->words(3, true),
            'slug' => Str::slug($name),
            'description' => $this->faker->realText(),
            'visible' => $this->faker->boolean(),
            'active' => $this->faker->boolean(),
            'sort' => $this->faker->randomNumber(),
            'seo_title' => $this->faker->sentence(),
            'seo_description' => $this->faker->realText(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}

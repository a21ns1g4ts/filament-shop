<?php

namespace A21ns1g4ts\FilamentShop\Database\Factories;

use A21ns1g4ts\FilamentShop\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->unique()->company(),
            'slug' => Str::slug($name),
            'website' => 'https://www.' . $this->faker->domainName(),
            'description' => $this->faker->realText(),
            'active' => $this->faker->boolean(),
            'visible' => $this->faker->boolean(),
            'sort' => $this->faker->randomNumber(),
            'seo_title' => $this->faker->sentence(),
            'seo_description' => $this->faker->realText(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => $this->faker->dateTimeBetween('-5 month', 'now'),
        ];
    }
}

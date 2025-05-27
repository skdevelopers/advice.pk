<?php

namespace Database\Factories;

use App\Models\Society;
use App\Models\SubSector;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubSectorFactory extends Factory
{
    protected $model = SubSector::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'title' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'meta_keywords' => $this->faker->word(),
            'meta_detail' => $this->faker->word(),
            'detail' => $this->faker->word(),
            'block' => $this->faker->word(),
            'registerMediaConversionsUsingModelInstance' => $this->faker->boolean(),

            'society_id' => Society::factory(),
        ];
    }
}

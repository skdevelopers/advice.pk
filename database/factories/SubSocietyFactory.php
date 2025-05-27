<?php

namespace Database\Factories;

use App\Models\Society;
use App\Models\SubSociety;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubSocietyFactory extends Factory
{
    protected $model = SubSociety::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'type' => $this->faker->word(),
            'meta_keywords' => $this->faker->word(),
            'meta_detail' => $this->faker->word(),
            'detail' => $this->faker->word(),

            'society_id' => Society::factory(),
        ];
    }
}

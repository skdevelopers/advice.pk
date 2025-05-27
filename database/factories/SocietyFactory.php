<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Society;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SocietyFactory extends Factory
{
    protected $model = Society::class;

    public function definition(): array
    {
        return [
            'society_name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'sub_sectors' => $this->faker->word(),
            'status' => $this->faker->word(),
            'meta_data' => $this->faker->words(),
            'map_data' => $this->faker->words(),
            'overview' => $this->faker->word(),
            'detail' => $this->faker->word(),
            'has_residential_plots' => $this->faker->boolean(),
            'has_commercial_plots' => $this->faker->boolean(),
            'has_houses' => $this->faker->boolean(),
            'has_apartments' => $this->faker->boolean(),
            'has_farm_houses' => $this->faker->boolean(),
            'has_shop' => $this->faker->boolean(),
            'property_types' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'registerMediaConversionsUsingModelInstance' => $this->faker->boolean(),

            'user_id' => User::factory(),
            'city_id' => City::factory(),
            'created_by' => User::factory(),
        ];
    }
}

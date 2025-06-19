<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'heading' => $this->faker->word(),
            'detail' => $this->faker->word(),
            'title' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'meta_keywords' => $this->faker->word(),
            'meta_description' => $this->faker->text(),
            'domain' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'registerMediaConversionsUsingModelInstance' => $this->faker->boolean(),
        ];
    }
}

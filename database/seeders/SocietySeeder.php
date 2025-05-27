<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Society;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Str;

class SocietySeeder extends Seeder
{
    public function run(): void
    {
        // Grab one user to own these records
        $userId = User::first()->id ?? 1;

        // For each city, create a dummy society
        City::all()->each(function ($city) use ($userId) {
            Society::create([
                'name'        => $city->name . ' Heights',
                'slug'        => Str::slug($city->name . ' Heights'),
                'city_id'     => $city->id,
                'user_id'     => $userId,
                'overview'    => 'Overview of ' . $city->name . ' Heights.',
                'detail'      => 'Detailed description for ' . $city->name . ' Heights.',
                'status'      => 'enabled',
                'created_by'  => $userId,
                // leave SEO fields empty or fill as needed
            ]);
        });
    }
}

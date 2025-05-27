<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    public function run(): void
    {

        City::truncate();
        // Array of city names
        $cities = [
            'Faisalabad',
            'Rawalpindi',
            'Islamabad',
            'Lahore',
            'Multan',
            'Bahawalpur',
            'Karachi',
            'Attock',
            'Peshawar',
            'Quetta',
        ];

        $data = [];
        foreach ($cities as $name) {
            $data[] = [
                'name'      => $name,
                'slug'      => Str::slug($name),
                'status'    => 'enabled',
                'created_at'=> now(),
                'updated_at'=> now(),
            ];
        }

        // Insert cities
        City::insert($data);

    }
}

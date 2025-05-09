<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Prishtinë', 'Mitrovicë', 'Pejë', 'Prizren', 'Ferizaj', 'Gjilan', 'Gjakovë'
        ];
        $latitudes = [
            42.66447931, 42.89227684, 42.66024010, 42.21705538, 42.37013579, 42.46382702, 42.38575844
        ];
        $longitudes = [
            21.16301788, 20.86519931, 20.28929151, 20.74317981, 21.14821839, 21.46890414, 20.42791632
        ];
        if (count($cities) === count($latitudes) && count($cities) === count($longitudes)) {
            foreach ($cities as $index => $city) {
                DB::table('cities')->insert([
                    'name' => $city,
                    'latitude' => $latitudes[$index],
                    'longitude' => $longitudes[$index],
                ]);
            }
        }
    }
}

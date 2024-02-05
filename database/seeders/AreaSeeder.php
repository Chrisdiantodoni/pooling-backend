<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            ['area_name' => 'NAD'],
            ['area_name' => 'MEDAN'],
            ['area_name' => 'SUMUT'],
            ['area_name' => 'PKU'],
            ['area_name' => 'RIDAR'],
            ['area_name' => 'RIKEP'],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }

    public static function getRandomArea(): string
    {
        $randomArea = Area::inRandomOrder()->first();
        if ($randomArea) {
            return $randomArea->area_name;
        }

        throw new \Exception('No dealers found.');
    }
}

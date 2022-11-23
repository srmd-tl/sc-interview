<?php

namespace Database\Seeders;

use App\Models\RoadMap;
use Illuminate\Database\Seeder;

class RoadMapSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'interchange_name' => 'Zero point',
                'distance'         => '0'
            ],
            [
                'interchange_name' => 'NS Interchange',
                'distance'         => '5'
            ],
            [
                'interchange_name' => 'Ph4 Interchange',
                'distance'         => '10'
            ],
            [
                'interchange_name' => 'Ferozpur Interchange',
                'distance'         => '17'
            ],
            [
                'interchange_name' => 'Lake City Interchange',
                'distance'         => '24'
            ],
            [
                'interchange_name' => 'Raiwand Interchange',
                'distance'         => '29'
            ],
            [
                'interchange_name' => 'Bahria Interchange',
                'distance'         => '34'
            ]
        ];
        RoadMap::insert( $data );
    }
}

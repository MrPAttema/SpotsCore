<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('locations')->insert([
        'location_name' => 'Belboei',
        'location' => 'Vlieland',
        'location_discription' => 'een zeer knus huisje',
        'location_price' => '235',
        'location_entertime' => '12:00',
        'location_exittime' => '11:00',
        'location_wifi' => '0',
        'location_tv' => '1',
        'location_radio' => '1',
        'location_shower' => '1',
        'location_publictransport' => '1',
        'location_smoking' => '0',
        'location_pets' => '0',
        'location_fireplace' => '1',
        'location_beds' => '6',
        'location_bedrooms' => '3',
        'location_maxpersons' => '6',
        'location_family' => '1',
        'location_tax' => '1.50',
      ]);
    }
}

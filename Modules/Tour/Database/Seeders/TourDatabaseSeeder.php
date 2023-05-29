<?php

namespace Modules\Tour\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Country;

class TourDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

         $this->call(TravelStyleDatabaseSeeder::class);
         $this->call(DestinationDatabaseSeeder::class);
         Country::factory(200)->create();
         City::factory(200)->create();
    }
}

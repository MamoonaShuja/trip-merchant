<?php

namespace Modules\Tour\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tour\Entities\Destination;

class DestinationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $destinations = [
          "North & Central America",
          "South America & Antarctica",
          "Australia, New Zealand & South Pacific",
          "Europe",
          "Africa",
          "Asia & Middle East",
        ];
        foreach ($destinations as $destination):
            Destination::create([
                "name" => $destination,
                "destination_uuid" => Str::uuid()
            ]);
        endforeach;
    }
}

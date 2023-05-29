<?php

namespace Modules\Tour\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Entities\TravelStyle;

class TravelStyleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $travelStyles = [
            "Ocean Cruises",
            "River Cruises",
            "Guided Tours",
            "Adventure & Active Travel",
            "African Safaris",
            "Rail Journeys",
            "Hotels & Resorts",
            "Luxury Travel",
            "Solo Travel",
            "Long Stay Vacations",
            "Vacation Homes & Rentals",
            "Private / Tailor Made",
        ];
        foreach ($travelStyles as $travelStyle):
            TravelStyle::create([
                "name" => $travelStyle,
                "travel_style_uuid" => Str::uuid(),
                "is_group" => 0
            ]);
        endforeach;

        $travelStyles = [
            "All Group Departures",
            "Trip Merchant Journeys - Group Departures"
        ];
        foreach ($travelStyles as $travelStyle):
            TravelStyle::create([
                "name" => $travelStyle,
                "travel_style_uuid" => Str::uuid(),
                "is_group" => 1
            ]);
        endforeach;
    }
}

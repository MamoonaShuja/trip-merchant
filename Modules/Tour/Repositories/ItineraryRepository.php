<?php

namespace Modules\Tour\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\ItineraryRepositoryContract;
use Modules\Tour\Entities\TourItinerary;

class ItineraryRepository implements ItineraryRepositoryContract
{
    public function __construct(private readonly TourItinerary $model) {}

    public function create(string|null $strDay, string|null $strHotelNames, string|null $strDescription, string|null $strMeals, string|null $strOptional): TourItinerary
    {
        $itinerary = new TourItinerary([
            'day' => $strDay,
            'hotel_names' => $strHotelNames,
            'description' => $strDescription,
            'meals' => $strMeals,
            'optional' => $strOptional,
            "tour_itinerary_uuid" => Str::uuid()
        ]);
        return $itinerary;
     }

    public function findById(int|null $id): Model|TourItinerary|null
    {
        return $this->model->newQuery()->find($id);
    }

    public function delete(TourItinerary $objTourItinerary): bool
    {
        return $objTourItinerary->delete();
    }

    public function update(TourItinerary $objTourItinerary ,  string|null $strDay, string|null $strHotelNames, string|null $strDescription, string|null $strMeals, string|null $strOptional,): TourItinerary
    {
        if (is_string($strDay) && $objTourItinerary->day !== $strDay) {
            $objTourItinerary->day = $strDay;
        }
        if (is_string($strHotelNames) && $objTourItinerary->day !== $strHotelNames) {
            $objTourItinerary->hotel_names = $strHotelNames;
        }
        if (is_string($strDescription) && $objTourItinerary->description !== $strDescription) {
            $objTourItinerary->description = $strDescription;
        }
        if (is_string($strMeals) && $objTourItinerary->meals !== $strMeals) {
            $objTourItinerary->meals = $strMeals;
        }
        if (is_string($strOptional) && $objTourItinerary->optional !== $strOptional) {
            $objTourItinerary->optional = $strOptional;
        }
        $objTourItinerary->save();
        return $objTourItinerary;
    }
}

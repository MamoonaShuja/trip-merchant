<?php

namespace Modules\Tour\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\AccommodationRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Modules\Tour\Entities\TourAccommodation;
class AccommodationRepository implements AccommodationRepositoryContract
{
    public function __construct(private readonly TourAccommodation $model) {}

    /**
     * @param string $strHotelName
     * @return TourAccommodation
     */
    public function create(string $strHotelName,
                         ): TourAccommodation
    {
        $accommodation = new TourAccommodation([
            'hotel_name' => $strHotelName,
            "tour_accommodation_uuid" => Str::uuid()
        ]);
        return $accommodation;
     }

    /**
     * @param int $id
     * @return Model|TourAccommodation|null
     */
    public function findById(int|null $id): Model|TourAccommodation|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->find($id);
    }

    /**
     * @param TourAccommodation $objTourAccommodation
     * @return bool
     */
    public function delete(TourAccommodation $objTourAccommodation): bool
    {
        $objTourAccommodation->ammenities()->delete();
        return $objTourAccommodation->delete();
    }

    /**
     * @param TourAccommodation $objTourAccommodation
     * @param string $strHotelName
     * @return TourAccommodation
     */
    public function update(TourAccommodation $objTourAccommodation ,
                           string  $strHotelName): TourAccommodation
    {
        if (is_string($strHotelName) && $objTourAccommodation->hotel_name !== $strHotelName) {
            $objTourAccommodation->hotel_name = $strHotelName;
        }
        $objTourAccommodation->save();
        return $objTourAccommodation;
    }

    /**
     * @param TourAccommodation $objTourAccommodation
     * @param array $objAccommodationAmenities
     * @return Collection
     */
    public function saveAmenities(TourAccommodation $objTourAccommodation, array $objAccommodationAmenities): Collection
    {
        $objTourAccommodation->ammenities()->saveMany($objAccommodationAmenities);
        return $objTourAccommodation->ammenities()->get();
    }

    /**
     * @param TourAccommodation $objTourAccommodation
     * @param array $objAccommodationAmenities
     * @return Collection
     */
    public function updateAmenities(TourAccommodation $objTourAccommodation, array $objAccommodationAmenities): Collection
    {
        $objTourAccommodation->ammenities()->sync($objAccommodationAmenities);
        return $objTourAccommodation->ammenities()->get();
    }
}

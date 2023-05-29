<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Tour\Entities\TourAccommodation;

interface AccommodationRepositoryContract
{
    /**
     * @param string $strHotelName
     * @return TourAccommodation
     */
    public function create(
        string $strHotelName,
      ): TourAccommodation;

    /**
     * @param int $id
     * @return Model|TourAccommodation|null
     */
    public function findById(int|null $id): Model|TourAccommodation|null;

    /**
     * @param TourAccommodation modation $tour
     * @return bool
     */
    public function delete(TourAccommodation $objTourAccommodation): bool;

    /**
     * @param TourAccommodation $objTourAccommodation
     * @param string $strHotelName
     * @return TourAccommodation
     */
    public function update(
        TourAccommodation $objTourAccommodation,
        string $strHotelName
    ): TourAccommodation;

    /**
     * @param TourAccommodation $objTourAccommodation
     * @param array $objAccommodationAmenities
     * @return Collection
     */
    public function saveAmenities(TourAccommodation $objTourAccommodation , array $objAccommodationAmenities):Collection;

    /**
     * @param TourAccommodation $objTourAccommodation
     * @param array $objAccommodationAmenities
     * @return Collection
     */
    public function updateAmenities(TourAccommodation $objTourAccommodation , array $objAccommodationAmenities):Collection;
}

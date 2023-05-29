<?php

namespace Modules\Tour\Contracts\Services;

use Illuminate\Support\Collection;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourAccommodation;

interface AccommodationAmenityContract
{

    /**
     * @param TourAccommodation $objTourAccommodation
     * @param int $accIndex
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveAccommodationAmenities(TourAccommodation $objTourAccommodation , int $accIndex , TourDTO $objTourDTO):Collection;

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateAccommodationAmenities(TourAccommodation $objTourAccommodation , int $accIndex ,TourDTO $objTourDTO):Collection;

    /**
     * @param array $accommodationsToDelete
     * @return void
     */
    public function deleteAccommodationAmenities(array $accommodationsToDelete):void;

}

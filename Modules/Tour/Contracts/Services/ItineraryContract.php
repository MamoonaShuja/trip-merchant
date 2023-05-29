<?php

namespace Modules\Tour\Contracts\Services;

use Modules\SupplierApi\Entities\ApiTourId;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

interface ItineraryContract
{

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveItineraries(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection;


    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return void
     */
    public function updateItineraries(Tour $objTour , TourDTO $objTourDTO):Collection;

    /**
     * @param array $itinerariesToDelete
     * @return void
     */
    public function deleteItineraries(array $itinerariesToDelete):void;
}

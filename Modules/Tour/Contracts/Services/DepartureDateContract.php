<?php

namespace Modules\Tour\Contracts\Services;

use Modules\SupplierApi\Entities\ApiTourId;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

interface DepartureDateContract
{

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveDepartureDates(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection;


    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateDepartureDates(Tour $objTour , TourDTO $objTourDTO):Collection;

    /**
     * @param array $departureDatesToDelete
     * @return void
     */
    public function deleteDepartureDates(array $departureDatesToDelete):void;
}

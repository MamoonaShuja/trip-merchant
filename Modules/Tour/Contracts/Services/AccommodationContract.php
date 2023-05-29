<?php

namespace Modules\Tour\Contracts\Services;

use Modules\SupplierApi\Entities\ApiTourId;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

interface AccommodationContract
{

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveAccommodations(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection;


    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateAccommodations(Tour $objTour , TourDTO $objTourDTO):Collection;

    /**
     * @param array $accommodationsToDelete
     * @return void
     */
    public function deleteAccommodations(array $accommodationsToDelete):void;


}

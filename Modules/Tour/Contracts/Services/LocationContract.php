<?php

namespace Modules\Tour\Contracts\Services;

use Modules\SupplierApi\Entities\ApiTourId;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

interface LocationContract
{

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveLocations(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection;
    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateLocations(Tour $objTour , TourDTO $objTourDTO):Collection;

    /**
     * @param array $locationsToDelete
     * @return void
     */
    public function deleteLocations(array $locationsToDelete):void;
    /**
     * @param Collection $savedEssentialInfos
     * @param TourDTO $objTourDTO
     * @return void
     */
    public function saveImages(Collection $savedEssentialInfos , TourDTO|ApiTourDTO $objTourDTO);
}

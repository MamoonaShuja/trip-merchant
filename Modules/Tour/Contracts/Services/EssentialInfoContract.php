<?php

namespace Modules\Tour\Contracts\Services;

use Modules\SupplierApi\Entities\ApiTourId;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

interface EssentialInfoContract
{
    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveEssentialInfos(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection;
    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateEssentialInfos(Tour $objTour , TourDTO $objTourDTO):Collection;

    /**
     * @param array $essentialInfosToDelete
     * @return void
     */
    public function deleteEssentialInfos(array $essentialInfosToDelete):void;

    public function savePdfs(Collection $savedEssentialInfos , TourDTO $objTourDTO);
}

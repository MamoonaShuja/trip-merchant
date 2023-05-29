<?php

namespace Modules\Tour\Contracts\Services;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

interface VideoContract
{

    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveVideos(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection;
    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateVideos(Tour $objTour , TourDTO $objTourDTO):Collection;

    /**
     * @param array $videosToDelete
     * @return void
     */
    public function deleteVideos(array $videosToDelete):void;
}

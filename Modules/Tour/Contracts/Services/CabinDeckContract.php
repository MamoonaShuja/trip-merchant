<?php

namespace Modules\Tour\Contracts\Services;

use Modules\SupplierApi\Entities\ApiTourId;
use Illuminate\Support\Collection;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Tour;

interface CabinDeckContract
{
    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function saveCabinDecks(Tour $objTour , TourDTO|ApiTourDTO $objTourDTO):Collection;
    /**
     * @param Tour $objTour
     * @param TourDTO $objTourDTO
     * @return Collection
     */
    public function updateCabinDeck(Tour $objTour , TourDTO $objTourDTO):Collection;

    /**
     * @param array $cabinDecksToDelete
     * @return void
     */
    public function deleteCabinDecks(array $cabinDecksToDelete):void;
}

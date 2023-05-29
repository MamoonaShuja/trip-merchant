<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Tour\Entities\TourCabinDeck;
use Modules\Tour\Entities\TourEssentialInfo;

interface CabinDeckRepositoryContract
{
    /**
     * @param string $strTitle
     * @param string $strDescription
     * @return TourCabinDeck
     */
    public function create(
        string $strTitle,
        string $strDescription,
      ): TourCabinDeck;

    /**
     * @param int $id
     * @return Model|TourCabinDeck|null
     */
    public function findById(int|null $id): Model|TourCabinDeck|null;

    /**
     * @param TourEssentialInfo $tour
     * @return bool
     */
    public function delete(TourCabinDeck $objCabinDeck): bool;

    /**
     * @param TourCabinDeck $objTourCabinDeck
     * @param string $strTitle
     * @param string $strDescription
     * @return TourCabinDeck
     */
    public function update(
        TourCabinDeck $objTourCabinDeck,
        string $strTitle,
        string $strDescription,
    ): TourCabinDeck;
}

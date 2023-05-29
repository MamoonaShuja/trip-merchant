<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourAccommodation;
use Modules\Tour\Entities\TourAccommodationAmenity;
use Modules\Tour\Entities\TourDepartureDate;
use Modules\Tour\Entities\TourLocation;

interface LocationRepositoryContract
{
    /**
     * @param string $strLat
     * @param string $strLong
     * @return TourLocation
     */
    public function create(
        string $strLat,
        string $strLong,
        bool $isImage
      ): TourLocation;

    /**
     * @param int $id
     * @return Model|TourLocation|null
     */
    public function findById(int|null $id): Model|TourLocation|null;

    /**
     * @param TourLocation $objTourLocation
     * @return bool
     */
    public function delete(TourLocation $objTourLocation): bool;

    /**
     * @param TourLocation $objTourLocation
     * @param string $strLat
     * @param string $strLong
     * @return TourLocation
     */
    public function update(
        TourLocation $objTourLocation,
        string $strLat,
        string $strLong,
        bool $isImage
    ): TourLocation;
}

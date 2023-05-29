<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourAccommodation;
use Modules\Tour\Entities\TourAccommodationAmenity;
use Modules\Tour\Entities\TourDepartureDate;

interface AccommodationAmenityRepositoryContract
{
    /**
     * @param string $strMetaKey
     * @param string $strMetaValue
     * @param string $strIcon
     * @return TourAccommodationAmenity
     */
    public function create(
        string $strMetaKey,
        string $strMetaValue,
        string $strIcon,
      ): TourAccommodationAmenity;

    /**
     * @param int $id
     * @return Model|TourAccommodationAmenity|null
     */
    public function findById(int|null $id): Model|TourAccommodationAmenity|null;

    /**
     * @param TourAccommodationAmenity $objTourAccommodationAmenity
     * @return bool
     */
    public function delete(TourAccommodationAmenity $objTourAccommodationAmenity): bool;

    /**
     * @param TourAccommodationAmenity $objTourAccommodationAmenity
     * @param string|null $strMetaKey
     * @param string|null $strMetaValue
     * @param string|null $strIcon
     * @return TourAccommodationAmenity
     */
    public function update(
        TourAccommodationAmenity $objTourAccommodationAmenity,
        string|null              $strMetaKey,
        string|null              $strMetaValue,
        string|null              $strIcon,
    ): TourAccommodationAmenity;
}

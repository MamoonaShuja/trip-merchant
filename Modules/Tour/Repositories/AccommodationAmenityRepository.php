<?php

namespace Modules\Tour\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\AccommodationAmenityRepositoryContract;
use Modules\Tour\Entities\TourAccommodationAmenity;

class AccommodationAmenityRepository implements AccommodationAmenityRepositoryContract
{
    /**
     * @param TourAccommodationAmenity $model
     */
    public function __construct(private readonly TourAccommodationAmenity $model) {}

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
    ): TourAccommodationAmenity
    {
        $accommodationAmenity = new TourAccommodationAmenity([
            'meta_key' => $strMetaKey,
            'meta_value' => $strMetaValue,
            'icon' => $strIcon,
            "tour_accommodation_amenity_uuid" => Str::uuid()
        ]);
        return $accommodationAmenity;
     }

    /**
     * @param int|null $id
     * @return Model|TourAccommodationAmenity|null
     */
    public function findById(int|null $id): Model|TourAccommodationAmenity|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->find($id);
    }

    /**
     * @param TourAccommodationAmenity $objTourAccommodationAmenity
     * @return bool
     */
    public function delete(TourAccommodationAmenity $objTourAccommodationAmenity): bool
    {
        return $objTourAccommodationAmenity->delete();
    }

    /**
     * @param TourAccommodationAmenity $objTourAccommodationAmenity
     * @param string|null $strMetaKey
     * @param string|null $strMetaValue
     * @param string|null $strIcon
     * @return TourAccommodationAmenity
     */
    public function update(TourAccommodationAmenity $objTourAccommodationAmenity ,
                           ?string                  $strMetaKey,
                           ?string                  $strMetaValue,
                           ?string                  $strIcon,
    ): TourAccommodationAmenity
    {

        if (is_string($strMetaKey) && $objTourAccommodationAmenity->meta_key !== $strMetaKey) {
            $objTourAccommodationAmenity->meta_key = $strMetaKey;
        }
        if (is_string($strMetaValue) && $objTourAccommodationAmenity->meta_value !== $strMetaValue) {
            $objTourAccommodationAmenity->meta_value = $strMetaValue;
        }
        if (is_string($strIcon) && $objTourAccommodationAmenity->icon !== $strIcon) {
            $objTourAccommodationAmenity->icon = $strIcon;
        }
        $objTourAccommodationAmenity->save();
        return $objTourAccommodationAmenity;
    }
}

<?php

namespace Modules\Tour\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\LocationRepositoryContract;
use Modules\Tour\Entities\TourLocation;

class LocationRepository implements LocationRepositoryContract
{
    /**
     * @param TourLocation $model
     */
    public function __construct(private readonly TourLocation $model) {}

    /**
     * @param string $strLat
     * @param string $strLong
     * @return TourLocation
     */
    public function create(
        string $strLat,
        string $strLong,
        bool $isImage,
    ): TourLocation
    {
        $location = new TourLocation([
            'lat' => $strLat,
            'long' => $strLong,
            'is_image' => $isImage,
            "tour_location_uuid" => Str::uuid()
        ]);
        return $location;
     }

    /**
     * @param int $id
     * @return Model|TourLocation|null
     */
    public function findById(int|null $id): Model|TourLocation|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->find($id);
    }

    /**
     * @param TourLocation $objTourLocation
     * @return bool
     */
    public function delete(TourLocation $objTourLocation): bool
    {
        return $objTourLocation->delete();
    }

    /**
     * @param TourLocation $objTourLocation
     * @param string|null $strLat
     * @param string|null $strLong
     * @return TourLocation
     */
    public function update(TourLocation $objTourLocation ,
                           ?string $strLat,
                           ?string $strLong,
                           bool $isImage
    ): TourLocation
    {
        if (is_string($strLat) && $objTourLocation->lat !== $strLat) {
            $objTourLocation->lat = $strLat;
        }
        if (is_string($strLong) && $objTourLocation->meta_value !== $strLong) {
            $objTourLocation->long = $strLong;
        }
        if (is_bool($isImage) && $objTourLocation->is_image !== $isImage) {
            $objTourLocation->is_image = $isImage;
        }

        $objTourLocation->save();
        return $objTourLocation;
    }
}

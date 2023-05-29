<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\TourAccommodationAmenity;

/** @mixin TourAccommodationAmenity */
class AccommodationAmmenitiesTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "meta_key" => $this->meta_key,
            "meta_value" => $this->meta_value,
            "icon" => $this->icon,
        ];
    }
}

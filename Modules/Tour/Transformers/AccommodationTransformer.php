<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\TourAccommodation;


/** @mixin TourAccommodation */
class AccommodationTransformer extends JsonResource
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
            "hotel_name" => $this->hotel_name,
            "amenities" => AccommodationAmmenitiesTransformer::collection($this->ammenities)
        ];
    }
}

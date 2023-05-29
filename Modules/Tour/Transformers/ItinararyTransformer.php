<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\TourAccommodation;
use Modules\Tour\Entities\TourItinerary;


/** @mixin TourItinerary */
class ItinararyTransformer extends JsonResource
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
            "day" => $this->day,
            "hotel_names" => $this->hotel_names,
            "description" => $this->description,
            "meals" => $this->meals,
            "optional" => $this->optional,
           ];
    }
}

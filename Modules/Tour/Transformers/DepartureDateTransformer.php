<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\TourDepartureDate;


/** @mixin TourDepartureDate */
class DepartureDateTransformer extends JsonResource
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
            "year" => $this->year,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "availability" => $this->availability,
            "price" => $this->price,
            "notes_link" => $this->notes_link,
            "optional_single_supplement" => $this->optional_single_supplement,
        ];
    }
}

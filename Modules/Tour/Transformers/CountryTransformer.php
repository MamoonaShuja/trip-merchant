<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Entities\Country;

/** @mixin Country */
class CountryTransformer extends JsonResource
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
            "uuid" => $this->country_uuid,
            "name"   => $this->name,
            "slug"   => $this->slug,
            "cities" => CityTransformer::collection($this->cities),
            "destination" => $this->destination->name,
            "destination_id" => $this->destination->id,
           ];
    }
}

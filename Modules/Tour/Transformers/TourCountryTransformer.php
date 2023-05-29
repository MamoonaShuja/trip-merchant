<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Entities\Country;

/** @mixin Country */
class TourCountryTransformer extends JsonResource
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
           ];
    }
}

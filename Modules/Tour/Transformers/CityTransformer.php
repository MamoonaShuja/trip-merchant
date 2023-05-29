<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\City;

/** @mixin City */
class CityTransformer extends JsonResource
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
            "uuid" => $this->city_uuid,
            "name"   => $this->name,
            "slug"   => $this->slug,
            "country"   => $this->country->name,
            "country_id"   => $this->country->id,
           ];
    }
}

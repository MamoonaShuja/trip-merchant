<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\TourLocation;
use Modules\Tour\Enum\MediaTypes;


/** @mixin TourLocation */
class LocationTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        if($this->is_image === 1) {
            $mapImage = $this->resource->medially
                ->where('type', MediaTypes::MAP->value)
                ->first();
        }else{
            $mapImage = null;
        }
        return [
            "id" => $this->id,
            "lat" => $this->lat,
            "long" => $this->long,
            "is_image" => $this->is_image,
            "map_image" => $mapImage
           ];
    }
}

<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Enum\MediaTypes;

/** @mixin Destination */
class TourDestinationTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */

    public function toArray($request)
    {
        $media = $this->resource->medially
            ->where('type', MediaTypes::FEATURED->value)
            ->first();
        $slider = $this->resource->medially
            ->where('type', MediaTypes::SLIDER->value)
            ->all();

        return [
            "id" => $this->id,
            "uuid" => $this->destination_uuid,
            "name"   => $this->name,
            "content" => $this->content,
            "slug" => $this->slug,
            "image"  => $media,
            "slider" => $slider,
        ];
    }
}

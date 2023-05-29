<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\TravelStyle;
use Modules\Tour\Enum\MediaTypes;

/** @mixin TravelStyle */
class TravelStyleTransformer extends JsonResource
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
            "uuid" => $this->travel_style_uuid,
            "name"   => $this->name,
            "content" => $this->content,
            "slug" => $this->slug,
            "is_group" => $this->is_group,
            "image"  => $media,
            "slider"  => $slider
        ];
    }
}

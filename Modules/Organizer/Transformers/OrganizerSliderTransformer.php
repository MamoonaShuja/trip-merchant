<?php

namespace Modules\Organizer\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Organizer\Entities\OrganizationSlider;
use Modules\Organizer\Entities\Setting;
use Modules\Tour\Enum\MediaTypes;
use stdClass;

/** @mixin OrganizationSlider */
class OrganizerSliderTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $slider = $this->resource->medially
            ->where('type', MediaTypes::SLIDER->value)
            ->first();

        return [
            "id" => $this->id,
            "uuid" => $this->organization_slider_uuid,
            "title"   => $this->title,
            "description"   => $this->description,
            "image"   => $slider,
        ];
    }
}

<?php

namespace Modules\Organizer\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Organizer\Entities\Setting;
use Modules\Organizer\Services\OrganizationSliderService;
use Modules\Tour\Enum\MediaTypes;
use stdClass;

/** @mixin Setting */
class SettingsTransformer extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        // Get the settings data from the resource
        $meta = $this->collection;
        // Create a new object to hold the combined data
        $combined = new stdClass();

        // Loop through each setting and add its data to the combined object
        foreach ($meta as $item) {
            $meta_key = $item->meta_key;
            $meta_value = $item->meta_value;
            $logo = $item->medially
                ->where('type', MediaTypes::LOGO->value)
                ->all();
            if($meta_key == MediaTypes::LOGO->value)
                $combined->$meta_key = $logo;
            elseif($meta_key == MediaTypes::SLIDER->value)
                $combined->$meta_key = OrganizerSliderTransformer::collection($item->sliders);
            else
                $combined->$meta_key = $meta_value;
        }

        // Return the combined object as an array
        return (array) $combined;
    }
}

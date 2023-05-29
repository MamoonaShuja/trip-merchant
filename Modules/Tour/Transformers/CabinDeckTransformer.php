<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\TourCabinDeck;
use Modules\Tour\Enum\MediaTypes;


/** @mixin TourCabinDeck */
class CabinDeckTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */

    public function toArray($request)
    {
        $pdfs = $this->resource->medially
            ->where('type', MediaTypes::CABIN_DECKS->value)
            ->first();
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "pdf" => $pdfs
           ];
    }
}

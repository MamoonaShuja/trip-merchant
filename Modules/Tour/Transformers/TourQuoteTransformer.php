<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Transformers\UserTransformer;
use Modules\Tour\Entities\TourQuote;

/** @mixin TourQuote */
class TourQuoteTransformer extends JsonResource
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
            "uuid" => $this->tour_quote_uuid,
            "description" => $this->description,
            "notes" => $this->note,
            "status" => $this->status,
            "city"   => new CityTransformer($this->city),
            "tour"   => new TourTransformer($this->tour),
            "user"   => new UserTransformer($this->user),
           ];
    }
}

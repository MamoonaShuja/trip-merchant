<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Tour\Entities\TourLocation;
use Modules\Tour\Entities\TourReview;


/** @mixin TourReview */
class ReviewTransformer extends JsonResource
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
            "rating_accommodation" => $this->rating_accommodation,
            "rating_overall" => $this->rating_overall,
            "rating_meals" => $this->rating_meals,
            "rating_transportation" => $this->rating_transportation,
            "name" => $this->name,
            "email" => $this->email,
            "comment" => $this->comment,
           ];
    }
}

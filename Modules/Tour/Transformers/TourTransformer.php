<?php

namespace Modules\Tour\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Transformers\UserTransformer;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Enum\MediaTypes;
use Modules\User\Entities\User;

/** @mixin Tour */
class TourTransformer extends JsonResource
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
            ->first() ?? null;
        $gallery = $this->resource->medially
            ->where('type', MediaTypes::GALLERY->value)
            ->all() ?? null;
        $slider = $this->resource->medially
            ->where('type', MediaTypes::SLIDER->value)
            ->all() ?? null;
        return [
            "id" => $this->id,
            "uuid" => $this->tour_uuid,
            "slug" => $this->slug,
            "title"   => $this->title,
            "members_rate" => $this->members_rate,
            "discount_members_rate" => $this->discount_members_rate,
            "members_benefit" => $this->members_benefit,
            "total_days" => $this->total_days,
            "total_nights" => $this->total_nights,
            "terms_and_conditions" => $this->terms_and_conditions,
            "overview" => $this->overview,
            "highlights" => $this->highlights,
            "included" => $this->included,
            "deposit_and_payments" => $this->deposit_and_payments,
            "not_included" => $this->not_included,
            "total_meals" => $this->total_meals,
            "activity_level" => $this->activity_level,
            "passenger_limit" => $this->passenger_limit,
            "upgrades" => $this->upgrades,
            "age_range" => $this->age_range,
            "is_visible" => $this->is_visible,
            "health_and_safety" => $this->health_and_safety,
            "travel_style_id" => $this->travel_style_id,
            "accommodations" => AccommodationTransformer::collection($this->accommodations),
            "departure_dates" => DepartureDateTransformer::collection($this->departureDates),
            "essential_info" => EssentialInfoTransformer::collection($this->essentialInfos),
            "faqs" => FaqTransformer::collection($this->faqs),
            "itinararies" => ItinararyTransformer::collection($this->itinarary),
            "locations" => LocationTransformer::collection($this->locations),
            "reviews" => ReviewTransformer::collection($this->reviews),
            "videos" => VideoTransformer::collection($this->videos),
            "travel_style" => new TravelStyleTransformer($this->travelStyle),
            "arrival_cities" => TourCityTransformer::collection($this->arrivalCities),
            "departure_cities" => TourCityTransformer::collection($this->departureCities),
            "destinations" => TourDestinationTransformer::collection($this->destinations),
            "countries" => TourCountryTransformer::collection($this->countries),
            "supplier" => new TourUserTransformer($this->supplier),
            "image"  => $media,
            "gallery"  => $gallery,
            "slider"  => $slider,
            "cabin_decks"  => CabinDeckTransformer::collection($this->cabinDecks),
            "organizations"  => TourUserTransformer::collection($this->organizations),
        ];
    }
}

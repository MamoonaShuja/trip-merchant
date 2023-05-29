<?php

namespace Modules\Tour\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\DestinationDTO;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Enum\Meals;
use Modules\Tour\Rules\OrganizerExists;
use Modules\User\Enum\UserType;

class UpdateTourRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "title" => ["required"],
            "members_rate" => ["required"],
            "discount_members_rate" => ["required"],
            "members_benefit" => ["sometimes" , "string"],
            "total_days" => ["sometimes" , "string"],
            "total_nights" => ["sometimes" , "string"],
            "terms_and_conditions" => ["sometimes" , "string"],
            "overview" => ["sometimes" , "string"],
            "highlights" => ["sometimes" , "string"],
            "included" => ["sometimes" , "string"],
            "deposit_and_payments" => ["sometimes" , "string"],
            "not_included" => ["sometimes" , "string"],
            "total_meals" => ["required" , "string"],
            "activity_level" => ["required" , "string"],
            "passenger_limit" => ["sometimes" , "string"],
            "upgrades" => ["sometimes" , "string"],
            "age_range" => ["sometimes" , "string"],
            "is_visible" => ["required" , "bool"],
            "arrival_cities" => ["required" , "array"],
            "arrival_cities.*" => ["required" , "string" , Rule::exists("cities", "id")],
            "departure_cities" => ["required" , "array"],
            "departure_cities.*" => ["required" , "string" , Rule::exists("cities", "id")],
            "travel_style_id" => ["required" , "string" , Rule::exists("travel_styles", "id")],
            "destinations" => ["required" , "array"],
            "destinations.*" => ["required" , "string" , Rule::exists("destinations", "id")],
            "countries" => ["required" , "array"],
            "countries.*" => ["required" , "string" , Rule::exists("countries", "id")],
            "itinerary" => ["sometimes" , "array"],
            "itinerary.*.id" => ["sometimes" , "int" , Rule::exists("tour_itineraries", "id")],
            "itinerary.*.day" => ["required" , "string"],
            "itinerary.*.hotel_names" => ["required" , "string"],
            "itinerary.*.description" => ["required" , "string" , "min:50"],
            "itinerary.*.meals" => ["required" , "string" , Rule::in(
                Meals::BREAKFAST->value,
                Meals::LUNCH->value,
                Meals::DINNER->value,
                Meals::BREAKFAST_DINNER_LUNCH->value,
                Meals::BREAKFAST_DINNER->value,
                Meals::BREAKFAST_LUNCH->value,
                Meals::LUNCH_DINNER->value
            )],
            "departure_dates" => ["sometimes" , "array"],
            "departure_dates.*.id" => ["sometimes" , "int" , Rule::exists("tour_departure_dates", "id")],
            "departure_dates.*.year" => ["required" , "string"],
            "departure_dates.*.start_date" => ["required" , "string"],
            "departure_dates.*.end_date" => ["required" , "string"],
            "departure_dates.*.availability" => ["required" , "string"],
            "departure_dates.*.price" => ["required" , "string"],
            "accommodations" => ["sometimes" , "array"],
            "accommodations.*.id" => ["sometimes" , "int" , Rule::exists("tour_accommodations", "id")],
            "accommodations.*.hotel_name" => ["sometimes" , "string"],
            "accommodations.*.amenities" => ["required" , "array"],
            "accommodations.*.amenities.*.id" => ["sometimes" , "int" , Rule::exists("tour_accommodation_amenities", "id")],
            "accommodations.*.amenities.*.meta_key" => ["required" , "string"],
            "accommodations.*.amenities.*.meta_value" => ["required" , "string"],
            "accommodations.*.amenities.*.icon" => ["required" , "string"],
            "locations" => ["sometimes" , "array" ],
            "locations.*.id" => ["sometimes" , "int" , Rule::exists("tour_locations", "id")],
            "locations.*.lat" => ["required" , "string" ],
            "locations.*.long" => ["required" , "string" ],
            "essential_info" => ["sometimes" , "array" ],
            "essential_info.*.id" => ["sometimes" , "int" , Rule::exists("tour_essential_infos", "id")],
            "essential_info.*.title" => ["required" , "string" ],
            "essential_info.*.description" => ["required" , "string" ],
            "videos" => ["sometimes" , "array" ],
            "videos.*.id" => ["sometimes" , "int" , Rule::exists("tour_videos", "id") ],
            "videos.*.video_link" => ["required" , "url" ],
            "organizations" => ["sometimes" , "array" ],
            "organizations.*" => ["required" ,   new OrganizerExists],
            "image" => ["sometimes" , 'image' , 'mimes:jpg,png'],
            "gallery" => ["sometimes" , "array"],
            "gallery.*" => ['image' ,'mimes:jpg,png'],
            "cabin_decks" => ["sometimes" , "array"],
            "cabin_decks.*" => ['required'],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Name is required",
        ];
    }


    public function getDTO(): TourDTO
    {
        return TourDTO::create(
            $this->input('title'),
            $this->input('members_rate'),
            $this->input('discount_members_rate'),
            $this->input('members_benefit'),
            $this->input('total_days'),
            $this->input('total_nights'),
            $this->input('terms_and_conditions'),
            $this->input('overview'),
            $this->input('highlights'),
            $this->input('included'),
            $this->input('deposit_and_payments'),
            $this->input('not_included'),
            $this->input('total_meals'),
            $this->input('activity_level'),
            $this->input('passenger_limit'),
            $this->input('upgrades'),
            $this->input('age_range'),
            $this->input('is_visible'),
            $this->input('arrival_cities'),
            $this->input('departure_cities'),
            $this->input('countries'),
            $this->input('travel_style_id'),
            $this->input('destinations'),
            $this->input('itinerary'),
            $this->input('departure_dates'),
            $this->input('accommodations'),
            $this->input('locations'),
            $this->input('essential_info'),
            $this->input('cabin_decks'),
            $this->input('videos'),
            $this->input('organizations'),
            $this->file('image'),
            $this->file('gallery'),
            $this->file('slider'),
            $this->file('cabin_decks'),
            $this->file('essential_info'),
        );
    }
}

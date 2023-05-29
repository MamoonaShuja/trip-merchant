<?php

namespace Modules\Tour\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\TourQuoteDTO;

class TourQuoteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "slug" => ["required" , Rule::exists("tours" , "slug")],
            "departure_city" => ["required" , Rule::exists("cities" , "city_uuid")],
            "passenger_number" => ["required"],
            "date" => ["required"],
            "description" => ["required"],
        ];
    }

    public function messages()
    {
        return [
            "slug.required" => "Tour Slug is required",
            "departure_city.required" => "City is required",
            "passenger_number.required" => "Passenger number is required",
            "description.required" => "Please enter some details",
        ];
    }


    public function getDTO(): TourQuoteDTO
    {
        return TourQuoteDTO::create(
            $this->input('slug'),
            $this->input('departure_city'),
            $this->input('passenger_number'),
            $this->input('date'),
            $this->input('description'),
            null,
            null
        );
    }
}

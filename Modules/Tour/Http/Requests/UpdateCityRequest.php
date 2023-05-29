<?php

namespace Modules\Tour\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\CityDTO;

class UpdateCityRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            "name" => ["required" , Rule::unique("cities", "name")->where(function ($query) {
                $query->where('city_uuid', '!=', $this->route('id'));
            }),],
            "country" => ["required" , Rule::exists("countries" , "country_uuid")],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Name is required",
        ];
    }

    /**
     * @return CityDTO
     */
    public function getDTO(): CityDTO
    {
        return CityDTO::create(
            $this->input('name'),
            $this->input('country'),
        );
    }
}

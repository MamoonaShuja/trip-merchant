<?php

namespace Modules\Tour\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\CityDTO;

class CreateCityRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ["required" , "unique:cities,name"],
            "country" => ["required" , Rule::exists("countries" , "country_uuid")],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Name is required",
            "country.required" => "Country is required",
        ];
    }


    public function getDTO(): CityDTO
    {
        return CityDTO::create(
            $this->input('name'),
            $this->input('country'),
        );
    }
}

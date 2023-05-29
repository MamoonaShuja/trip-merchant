<?php

namespace Modules\Tour\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\CityDTO;
use Modules\Tour\DataTransfer\Requests\CountryDTO;

class CountryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ["required" , Rule::unique("countries", "name")->where(function ($query) {
                if($this->route('uuid'))
                    return $query->where('country_uuid', '!=', $this->route('uuid'));
                return true;
            })],
            "destination" => ["required" , Rule::exists("destinations" , "destination_uuid")],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Name is required",
            "destination.required" => "Destination is required",
        ];
    }


    public function getDTO(): CountryDTO
    {
        return CountryDTO::create(
            $this->input('name'),
            $this->input('destination'),
        );
    }
}

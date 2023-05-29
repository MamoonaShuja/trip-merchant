<?php

namespace Modules\Tour\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\CityDTO;
use Modules\Tour\DataTransfer\Requests\GeneralFilterDTO;

class GeneralFilterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
          ];
    }

    public function messages()
    {
        return [
            ];
    }


    public function getDTO(): GeneralFilterDTO
    {
        return GeneralFilterDTO::create(
            $this->query('name'),
            $this->query('destination_id'),
            $this->query('date'),
            $this->query('city_id'),
            $this->input('country_id'),
            $this->query('travel_style_id'),
            $this->query('supplier_id'),
            $this->query('start_date'),
            $this->query('end_date'),
            $this->query('start_price'),
            $this->query('end_price'),
        );
    }
}

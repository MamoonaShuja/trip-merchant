<?php

namespace Modules\Tour\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\OceanCruisesFilterDTO;

class OceanCruisesFilterRequest extends BaseRequest
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


    public function getDTO(): OceanCruisesFilterDTO
    {
        return OceanCruisesFilterDTO::create(
            $this->query('travel_style_id'),
            $this->query('destination_id'),
            $this->query('start_date'),
            $this->query('end_date'),
            $this->query('start_price'),
            $this->query('end_price'),
            $this->query('itinerary_name')
        );
    }
}

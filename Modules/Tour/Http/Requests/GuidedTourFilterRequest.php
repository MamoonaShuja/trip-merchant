<?php

namespace Modules\Tour\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\CityDTO;
use Modules\Tour\DataTransfer\Requests\GeneralFilterDTO;
use Modules\Tour\DataTransfer\Requests\GuidedTourFilterDTO;

class GuidedTourFilterRequest extends BaseRequest
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


    public function getDTO(): GuidedTourFilterDTO
    {
        return GuidedTourFilterDTO::create(
            $this->query('supplier_id'),
            $this->query('destination_id'),
            $this->query('start_date'),
            $this->query('end_date'),
            $this->query('start_price'),
            $this->query('end_price'),
            $this->query('itinerary_name'),
            $this->query('travel_style_id'),
        );
    }
}

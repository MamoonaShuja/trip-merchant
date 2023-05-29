<?php

namespace Modules\Tour\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\TourQuoteDTO;

class UpdateTourQuoteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "status" => ["required"],
            "notes" => ["required"],

        ];
    }

    public function messages()
    {
        return [
            "status.required" => "Status is required",
            "notes.required" => "Notes are required",
        ];
    }


    public function getDTO(): TourQuoteDTO
    {
        return TourQuoteDTO::create(
            null,
            null,
            null,
            null,
            null,
            $this->input('status'),
            $this->input('notes'),
        );
    }
}

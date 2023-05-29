<?php

namespace Modules\Organizer\Http\Requests;

use Modules\Organizer\DataTransfer\Requests\UpdateSliderDTO;
use Modules\Core\Http\Requests\BaseRequest;

final class UpdateSliderRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string|array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            "title"   => ["required"],
            "description" => ['required'],
            "slider" => ['sometimes' , 'image'],
        ];
    }


    public function getDTO(): UpdateSliderDTO
    {
        return UpdateSliderDTO::create(
            $this->input("title"),
            $this->input("description"),
            $this->file("slider"),
        );
    }
}

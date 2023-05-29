<?php

namespace Modules\Tour\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\TravelStyleDTO;

class CreateTravelStyleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ["required" , "unique:travel_styles,name"],
            "is_group" => ["required"],
            "image" => ["sometimes" , 'image' ,'mimes:jpg,png'],
            "slider" => ["sometimes" , "array"],
            "slider.*" => ['image' ,'mimes:jpg,png'],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Name is required",
            "is_group.required" => "Group/Single is required",
        ];
    }


    public function getDTO(): TravelStyleDTO
    {
        return TravelStyleDTO::create(
            $this->input('name'),
            $this->input('content'),
            $this->input('is_group'),
            $this->file('image'),
            $this->file('slider')
        );
    }
}

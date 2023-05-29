<?php

namespace Modules\Tour\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\DataTransfer\DTO;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\TravelStyleDTO;

class UpdateTravelStyleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required" , Rule::unique("travel_styles", "name")->where(function ($query) {
                $query->where('travel_style_uuid', '!=', $this->route('id'));
            }),],
            "is_group" => ["required"],
            "content" => ["required"],
            "image" => ["sometimes", "mimes:jpeg,jpg,png,gif" , "max:100000"],
            "slider" => ["sometimes", "array"],
            "slider.*" => ["mimes:jpeg,jpg,png,gif" , "max:100000"]
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "Name is required",
            "content.required" => "Content is required",
            "is_group.required" => "Group/Single is required",
            "image.mimes" => "Invalid type",
            "image.max" => "Invalid file size",
        ];
    }

    /**
     * @return DTO|TravelStyleDTO
     */
    public function getDTO(): TravelStyleDTO
    {
        return TravelStyleDTO::create(
            $this->input('name'),
            $this->input('content'),
            $this->input('is_group'),
            $this->file('image'),
            $this->file('slider'),
        );
    }

}

<?php

namespace Modules\Tour\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\DestinationDTO;

class UpdateDestinationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required"],
            "content" => ["required"],
            "image" => ["sometimes", "mimes:jpeg,jpg,png,gif", "max:100000"],
            "slider" => ["sometimes", "array"],
            "slider.*" => ["mimes:jpeg,jpg,png,gif", "max:100000"]
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Name is required",
            "content.required" => "Content is required",
            "image.mimes" => "Invalid type",
            "image.max" => "Invalid file size",
        ];
    }

    /**
     * @return DestinationDTO
     */
    public function getDTO(): DestinationDTO
    {
        return DestinationDTO::create(
            $this->input('name'),
            $this->input('content'),
            $this->file('image'),
            $this->file('slider'),
        );
    }
}

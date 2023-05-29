<?php

namespace Modules\Tour\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\DestinationDTO;

class CreateDestinationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ["required" , Rule::unique("destinations", "name")],
            "content" => ["sometimes" , 'string'],
            "image" => ["sometimes" , 'image' ,'mimes:jpg,png'],
            "slider" => ["sometimes" , "array"],
            "slider.*" => ['image' ,'mimes:jpg,png'],

        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Name is required",
        ];
    }


    public function getDTO(): DestinationDTO
    {
        return DestinationDTO::create(
            $this->input('name'),
            $this->input('content'),
            $this->file('image'),
            $this->file('slider')
        );
    }
}

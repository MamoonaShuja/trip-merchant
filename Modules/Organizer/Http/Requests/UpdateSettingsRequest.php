<?php

namespace Modules\Organizer\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Organizer\DataTransfer\Requests\UpdateSettingsDTO;
use Modules\Core\Http\Requests\BaseRequest;

final class UpdateSettingsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string|array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            "meta_key"   => ["required" , "array"],
            "meta_key.*" => ['required'],
            "files_meta" => ['sometimes' , "array"],
            "files_meta.*" => ['required' , 'file'],
            "slider" => ['required' , 'array'],
            "slider.*.title" => ['required' , 'string'],
            "slider.*.description" => ['required' , 'string'],
            "slider.*.image" => ['sometimes' , 'file'],
            "slider.*.uuid" => ['sometimes' , Rule::exists("organization_sliders" , "organization_slider_uuid")],
        ];
    }


    public function getDTO(): UpdateSettingsDTO
    {
        return UpdateSettingsDTO::create(
            $this->input("meta_key"),
            $this->file("files_meta"),
            $this->input("slider"),
            $this->file("slider"),
        );
    }
}

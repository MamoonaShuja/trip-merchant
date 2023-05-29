<?php

namespace Modules\Tour\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\CityDTO;
use Modules\Tour\DataTransfer\Requests\FilesUploadDTO;
use Modules\Tour\DataTransfer\Requests\FileUploadDTO;

class UpdateGalleryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "gallery" => ["required" , "array"],
            "gallery.*" => ["image" , "mimes:png,jpg"],
        ];
    }


    /**
     * @return CityDTO
     */
    public function getDTO(): FilesUploadDTO
    {
        return FilesUploadDTO::create(
            $this->file('gallery'),
        );
    }
}

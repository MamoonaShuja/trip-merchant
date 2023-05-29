<?php

namespace Modules\Tour\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;
use Modules\Tour\DataTransfer\Requests\CityDTO;
use Modules\Tour\DataTransfer\Requests\FilesUploadDTO;
use Modules\Tour\DataTransfer\Requests\FileUploadDTO;

class UpdateCabinDeckRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "slider" => ["required" , "array"],
        ];
    }


    /**
     * @return CityDTO
     */
    public function getDTO(): FilesUploadDTO
    {
        return FilesUploadDTO::create(
            $this->file('slider'),
        );
    }
}

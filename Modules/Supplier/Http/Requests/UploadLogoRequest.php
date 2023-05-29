<?php

namespace Modules\Supplier\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;
use Modules\User\DataTransfer\Requests\UploadAvatarDTO;

final class UploadLogoRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string|array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            "logo" => ["required", "mimes:jpeg,jpg,png,gif" , "max:100000"],
        ];
    }


    /**
     * @return UploadAvatarDTO
     */
    public function getDTO(): UploadAvatarDTO
    {
        return UploadAvatarDTO::create(
            $this->file('logo')
        );
    }
}

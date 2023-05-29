<?php

namespace Modules\User\Http\Requests;

use Modules\Core\Http\Requests\BaseRequest;
use Modules\User\DataTransfer\Requests\UploadAvatarDTO;

final class UploadAvatarRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string|array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            "avatar" => ["required", "mimes:jpeg,jpg,png,gif" , "max:100000"],
        ];
    }


    /**
     * @return UploadAvatarDTO
     */
    public function getDTO(): UploadAvatarDTO
    {
        return UploadAvatarDTO::create(
            $this->file('avatar')
        );
    }
}

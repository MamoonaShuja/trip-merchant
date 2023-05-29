<?php

namespace Modules\User\Http\Requests;

use Modules\Core\DataTransfer\DTO;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\User\DataTransfer\Requests\ChangePasswordDTO;

final class ChangePasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "current_password" => "required|string",
            "password"         => "required|string|confirmed"
        ];
    }

    /**
     * @return ChangePasswordDTO
     */
    public function getDTO(): ChangePasswordDTO {
        return ChangePasswordDTO::create(
            $this->input("current_password"),
            $this->input("password"),
        );
    }
}

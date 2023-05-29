<?php

namespace Modules\User\Http\Requests\Authentication;

use Modules\Core\Http\Requests\BaseRequest;
use Modules\User\DataTransfer\Requests\ForgetPasswordDTO;

final class ForgetPasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            "email"    => "required|email|exists:users,email",
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            "email.required"    => "Email field is required.",
            "email.email"       => "Please enter correct email.",
            "email.exists"      => "Sorry this email doesn't belong to our system.",
        ];
    }

    public function getDTO(): ForgetPasswordDTO
    {
        return ForgetPasswordDTO::create(
            strval($this->input("email"))
        );
    }
}

<?php

namespace Modules\User\Http\Requests\Authentication;

use Modules\Core\Http\Requests\BaseRequest;
use Modules\User\DataTransfer\Requests\SignInDTO;

final class SignInRequest extends BaseRequest
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
            "password" => "required|string",
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
            "email.exists"      => "The provided credentials are incorrect.",
            "password.required" => "Password field is required.",
            "password.string"   => "Password field must be a string.",
        ];
    }

    public function getDTO(): SignInDTO
    {
        return SignInDTO::create(
            strval($this->input("email")),
            strval($this->input("password"))
        );
    }
}

<?php

namespace Modules\User\Http\Requests\Authentication;

use Modules\Core\Http\Requests\BaseRequest;
use Modules\User\DataTransfer\Requests\ForgetPasswordDTO;
use Modules\User\DataTransfer\Requests\ResetPasswordDTO;
use Modules\User\DataTransfer\Requests\SignInDTO;

final class ResetPasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            "password"  => "required|string|min:6|confirmed",
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            "email.required"    => "Email field is required.",
            "email.email"       => "Email must be email.",
            "email.exists"      => "The provided credentials are incorrect.",
            "password.required"  => "Password field is required.",
            "password.string"    => "Password field must be a string.",
            "password.min"       => "Name should contain at least 1 character.",
            "password.confirmed" => "Password confirmation miss match.",
        ];
    }

    public function getDTO(): ResetPasswordDTO
    {
        return ResetPasswordDTO::create(
            strval($this->input("token")),
            strval($this->input("email")),
            strval($this->input("password")),
            strval($this->input("password_confirmation")),
        );
    }
}

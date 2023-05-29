<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\User\DataTransfer\Requests\SignUpDTO;

final class CreateAdminRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string|array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            "first_name"      => "required|string|min:3|max:99",
            "last_name"      => "required|string|min:3|max:99",
            "email"     => "required|email|max:99|unique:users,email",
            "password"  => "required|string|min:6|confirmed",
            "role" => ["required" , Rule::exists("roles" , "role_uuid")]
        ];
    }


    public function getDTO(): SignUpDTO
    {
        return SignUpDTO::create(
            strval($this->input("first_name")),
            strval($this->input("last_name")),
            strval($this->input("email")),
            strval($this->input("password")),
            null,
            null,
            null,
            null,
            null,
            null,
            $this->input('role')
        );
    }
}

<?php

namespace Modules\User\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\User\DataTransfer\Requests\UpdateUserDTO;

final class UserUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string|array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            "first_name"         => "string",
            "last_name"         => "string",
            "contact"         => "string",
            "dob"         => "string",
            "city"         => "string",
            "province"         => "string",
            "country"         => "string",
            "msg"         => "string",
            "bio"         => "string",
            "email"        => [
                "required",
                "string",
                "email",
                Rule::unique("users", "email")->ignore(Auth::id())
            ],
        ];
    }


    public function getDTO(): UpdateUserDTO
    {
        return UpdateUserDTO::create(
            $this->input("first_name"),
            $this->input("last_name"),
            $this->input("email"),
            $this->input("contact"),
            $this->input("dob"),
            $this->input("city"),
            $this->input("province"),
            $this->input("country"),
            $this->input("organization_name"),
            $this->input("website"),
            $this->input("message"),
            $this->input("bio"),
            $this->input("no_of_employees"),
            $this->input("code"),
            $this->input("organization_code"),
            $this->input("domain"),
        );
    }
}

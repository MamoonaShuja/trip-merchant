<?php

namespace Modules\Supplier\Http\Requests\Authentication;

use Modules\Core\Http\Requests\BaseRequest;
use Modules\User\DataTransfer\Requests\SignUpDTO;

final class SupplierSignUpRequest extends BaseRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string|array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            "first_name"      => "required|string|min:1|max:99",
            "last_name"      => "required|string|min:1|max:99",
            "email"     => "required|email|max:99|unique:users,email",
            "website"  => "sometimes|string|unique:users,website",
            "message"  => "sometimes|string",
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => "Email must be unique"
        ]; // TODO: Change the autogenerated stub
    }

    public function getDTO(): SignUpDTO
    {
        return SignUpDTO::create(
            strval($this->input("first_name")),
            strval($this->input("last_name")),
            strval($this->input("email")),
            $this->generateRandomPassword(),
            null,
            strval($this->input("website")),
            null,
            null,
            $this->input("message"),
            $this->file("avatar"),
            null
        );
    }
}
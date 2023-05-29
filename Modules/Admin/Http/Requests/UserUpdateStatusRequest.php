<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Admin\DataTransfer\Requests\UpdateUserStatusDTO;
use Modules\Core\Http\Requests\BaseRequest;
final class UserUpdateStatusRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string|array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            "status"         => "required|string",
            "password"         => "required|string",
            "organization_code"        => [
                "sometimes",
                "string",
                 Rule::unique("users", "organization_code")
                     ->where(function ($query) {
                         $query->where('user_uuid', '!=', $this->route('uuid'));
                     })
            ],
            "domain" => [
                "sometimes",
                Rule::unique("users", "domain")->where(function ($query) {
                    $query->where('user_uuid', '!=', $this->route('uuid'));
                }),
            ],
        ];
    }


    public function getDTO(): UpdateUserStatusDTO
    {
        return UpdateUserStatusDTO::create(
            $this->input("status"),
            $this->input("password"),
            $this->input("organization_code"),
            $this->input("domain"),
            $this->input("admin_message")
        );
    }
}

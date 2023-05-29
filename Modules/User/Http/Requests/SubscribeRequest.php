<?php

namespace Modules\User\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\DataTransfer\DTO;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\User\DataTransfer\Requests\ChangePasswordDTO;
use Modules\User\DataTransfer\Requests\SubscriberDTO;

final class SubscribeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => ["required", "string" , "unique:subscribers,email"],
            "organization_uuid"  => ["sometimes" ,"string"  , Rule::exists("users" , "user_uuid")]
        ];
    }

    /**
     * @return ChangePasswordDTO
     */
    public function getDTO(): SubscriberDTO {
        return SubscriberDTO::create(
            $this->input("email"),
            $this->input("organization_uuid"),
        );
    }
}

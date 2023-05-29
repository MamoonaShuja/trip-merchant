<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Admin\DataTransfer\Requests\AssignPermissionDTO;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\User\DataTransfer\Requests\SignUpDTO;

final class AssignPermissionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string|array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            "permissions" => ['required' , 'array'],
            "permissions.*" => [Rule::exists("permissions" , "id")]
        ];
    }


    public function getDTO(): AssignPermissionDTO
    {
        return AssignPermissionDTO::create(
            $this->input('permissions')
        );
    }
}

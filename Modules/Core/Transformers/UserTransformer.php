<?php

namespace Modules\Core\Transformers;

use Illuminate\Http\Request;
use Modules\Tour\Enum\MediaTypes;
use Modules\User\Entities\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Enum\UserType;

/**
 * @mixin  User
 */
class UserTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $media = $this->resource->medially
            ->where('type', MediaTypes::FEATURED->value)
            ->first();
        $arr = [
            "id" => $this->id,
            "uuid" => $this->user_uuid,
            "slug" => $this->slug,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "email_verified" => !is_null($this->email_verified_at),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "is_approved" => $this->is_approved,
            "avatar" => $media,
            "role" => $this->role->name,
            "members_count" => $this->members()->count()
        ];
        if ($this->role->name == UserType::ORGANIZER->value || $this->role->name == UserType::EMPLOYEE->value):
            $arr['organization_name'] = $this->organization_name;
            $arr['no_of_employees'] = $this->no_of_employees;
            $arr['organization_code'] = $this->organization_code;
            $arr['subscriber'] = $this->subscribers;
            $arr['message'] = $this->message;
            $arr['domain'] = $this->domain;
        elseif ($this->role->name == UserType::SUPPLIER->value):
            $logo = $this->resource->medially
                ->where('type', MediaTypes::LOGO->value)
                ->first();
            $arr['website'] = $this->website;
            $arr['bio'] = $this->bio;
            $arr['message'] = $this->message;
            $arr['logo'] = $logo;
        elseif ($this->role->name == UserType::MEMBER->value):
            $arr['domain'] = $this->organization->domain;
            $arr['contact'] = $this->contact;
            $arr['dob'] = $this->dob;
            $arr['city'] = $this->city;
            $arr['province'] = $this->province;
            $arr['country'] = $this->country;
            $arr['organization'] = new UserTransformer($this->organization);
        else:
            $arr['permissions'] = new RoleTransformer($this->role);
        endif;
        if ($this->is_approved != 1):
            $arr['admin_message'] = $this->admin_message;
        endif;

        return $arr;
    }
}

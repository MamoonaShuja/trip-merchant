<?php

namespace Modules\Core\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Entities\Subscriber;

/** @mixin Subscriber */
class SubscriberTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "email"   => $this->email,
            "uuid"   => $this->subscribers_uuid,
            "organization" => $this->organization->organization_name,
        ];
    }
}

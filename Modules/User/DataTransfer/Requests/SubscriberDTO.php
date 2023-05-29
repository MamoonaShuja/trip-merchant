<?php

namespace Modules\User\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class SubscriberDTO implements DTO
{

    /**
     * @param string $email
     * @param string|null $organization_uuid
     */
    public function __construct(
        private readonly string $email,
        private readonly string|null $organization_uuid
    ) { }

    /**
     * @param string $email
     * @param string $organization_uuid
     */
    public static function create(
        string $email,
        string|null $organization_uuid,
    ): self {
        return new self($email , $organization_uuid);
    }
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getOrganizationUuid(): string|null
    {
        return $this->organization_uuid;
    }


}

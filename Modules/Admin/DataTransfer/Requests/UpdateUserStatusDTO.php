<?php

namespace Modules\Admin\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class UpdateUserStatusDTO implements DTO
{
    /**
     * @param string|null $status
     * @param string $password
     * @param string|null $organization_code
     * @param string|null $domain
     */
    public function __construct(
        private readonly string|null $status,
        private readonly string      $password,
        private readonly string|null $organization_code,
        private readonly string|null $domain,
        private readonly string|null $admin_message,
    ) { }

    /**
     * @param string|null $status
     * @param string|null $password
     * @param string|null $organization_code
     * @param string|null $domain
     * @param string|null $admin_message
     * @return static
     */
    public static function create(
        string|null $status,
        string|null $password,
        string|null $organization_code,
        string|null $domain,
        string|null $admin_message,
    ): self {
        return new self($status, $password, $organization_code, $domain, $admin_message);
    }

    /**
     * @return string|null
     */
    public function getOrganizationCode(): string|null
    {
        return $this->organization_code;
    }

    /**
     * @return string|null
     */
    public function getPassword(): string|null
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getStatus(): string|null
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getDomain(): string|null
    {
        return $this->domain;
    }
    public function getAdminMessage(): string|null
    {
        return $this->admin_message;
    }

}

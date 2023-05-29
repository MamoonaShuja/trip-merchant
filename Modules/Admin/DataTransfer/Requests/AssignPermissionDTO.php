<?php

namespace Modules\Admin\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class AssignPermissionDTO implements DTO
{
    /**
     * @param array $meta_key
     * @param array $meta_value
     */
    public function __construct(
        private readonly array $permissions
    ) { }

    /**
     * @param array $meta_key
     * @param array $meta_value
     * @return static
     */
    public static function create(
        array $permissions,
    ): self {
        return new self($permissions);
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }


}

<?php

namespace Modules\User\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class ChangePasswordDTO implements DTO
{
    /**
     * @param string $currentPassword
     * @param string $newPassword
     */
    public function __construct(
        private readonly string $currentPassword,
        private readonly string $newPassword
    ) {}

    /**
     * @param string $currentPassword
     * @param string $newPassword
     * @return static
     */
    public static function create(string $currentPassword, string $newPassword): self
    {
        return new self($currentPassword, $newPassword);
    }

    /**
     * @return string
     */
    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }
}

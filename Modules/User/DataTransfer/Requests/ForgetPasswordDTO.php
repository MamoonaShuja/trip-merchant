<?php

namespace Modules\User\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class ForgetPasswordDTO implements DTO
{
    /**
     * @param string $email
     */
    public function __construct(
        private readonly string $email,
    ) { }

    /**
     * @param string $email
     * @return static
     */
    public static function create(string $email): self
    {
        return new self($email);
    }

    /**
     * @return string
     *
     */
    public function getEmail(): string
    {
        return $this->email;
    }

}

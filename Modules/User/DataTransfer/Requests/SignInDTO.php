<?php

namespace Modules\User\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class SignInDTO implements DTO
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        private readonly string $email,
        private readonly string $password,
    ) { }

    /**
     * @param string $email
     * @param string $password
     * @return static
     */
    public static function create(string $email, string $password): self
    {
        return new self($email, $password);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}

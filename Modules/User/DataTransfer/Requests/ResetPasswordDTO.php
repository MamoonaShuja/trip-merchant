<?php

namespace Modules\User\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class ResetPasswordDTO implements DTO
{
    /**
     * @param string $token
     * @param string $email
     * @param string $password
     * @param string $password_confirmation
     */
    public function __construct(
        private readonly string $token,
        private readonly string $email,
        private readonly string $password,
        private readonly string $password_confirmation,
    ) { }

    /**
     * @param string $token
     * @param string $email
     * @param string $password
     * @param string $password_confirmation
     * @return static
     */
    public static function create(string $token, string $email, string $password, string $password_confirmation): self
    {
        return new self($token , $email , $password , $password_confirmation);
    }

    /**
     * @return string
     *
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
    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
    /**
     * @return string
     */
    public function getPasswordConfirmation(): string
    {
        return $this->password_confirmation;
    }
}

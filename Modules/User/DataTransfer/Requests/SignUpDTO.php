<?php

namespace Modules\User\DataTransfer\Requests;

use Illuminate\Http\UploadedFile;
use Modules\Core\DataTransfer\DTO;

final class SignUpDTO implements DTO
{

    /**
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string|null $password
     * @param string|null $code
     * @param string|null $website
     * @param string|null $organization_name
     * @param string|null $no_of_employees
     * @param string|null $message
     * @param UploadedFile|null $avatar
     * @param array|null $permisssions
     */
    public function __construct(
        private readonly string            $first_name,
        private readonly string            $last_name,
        private readonly string            $email,
        private readonly string|null       $password,
        private readonly string|null       $code,
        private readonly string|null       $website,
        private readonly string|null       $organization_name,
        private readonly string|null       $no_of_employees,
        private readonly string|null       $message,
        private readonly null|UploadedFile $avatar,
        private readonly string|null $role,
    ) { }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param UploadedFile|null $avatar
     * @return static
     */
    public static function create(
        string       $first_name,
        string       $last_name,
        string       $email,
        string       $password,
        string|null  $code,
        string|null  $website,
        string|null  $organization_name,
        string|null  $no_of_employees,
        string|null  $message,
        UploadedFile|null $avatar,
        string|null $role,
    ): self {
        return new self($first_name,$last_name, $email, $password , $code , $website , $organization_name , $no_of_employees , $message , $avatar , $role);
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
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

    /**
     * @return string|null
     */
    public function getCode(): string|null
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @return string|null
     */
    public function getOrganizationName(): ?string
    {
        return $this->organization_name;
    }

    /**
     * @return string|null
     */
    public function getNoOfEmployees(): ?string
    {
        return $this->no_of_employees;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return UploadedFile
     */
    public function getAvatar(): UploadedFile|null
    {
        return $this->avatar;
    }

    /**
     * @return string|null
     */
    public function getRole(): string|null
    {
        return $this->role;
    }


}

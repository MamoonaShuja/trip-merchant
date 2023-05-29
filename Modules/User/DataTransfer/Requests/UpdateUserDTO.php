<?php

namespace Modules\User\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class UpdateUserDTO implements DTO
{
    /**
     * @param string|null $first_name
     * @param string|null $last_name
     * @param string|null $email
     * @param string|null $dob
     * @param string|null $city
     * @param string|null $province
     * @param string|null $country
     * @param string|null $organization_name
     * @param string|null $website
     * @param string|null $message
     * @param string|null $no_of_employees
     * @param string|null $code
     * @param string|null $organization_code
     * @param string|null $domain
     */
    public function __construct(
        private readonly string|null $first_name,
        private readonly string|null $last_name,
        private readonly string|null $email,
        private readonly string|null $contact,
        private readonly string|null $dob,
        private readonly string|null $city,
        private readonly string|null $province,
        private readonly string|null $country,
        private readonly string|null $organization_name,
        private readonly string|null $website,
        private readonly string|null $message,
        private readonly string|null $bio,
        private readonly string|null $no_of_employees,
        private readonly string|null $code,
        private readonly string|null $organization_code,
        private readonly string|null $domain,
    ) { }

    /**
     * @param string|null $first_name
     * @param string|null $last_name
     * @param string|null $email
     * @param string|null $dob
     * @param string|null $city
     * @param string|null $province
     * @param string|null $country
     * @param string|null $organization_name
     * @param string|null $website
     * @param string|null $message
     * @param string|null $no_of_employees
     * @param string|null $code
     * @param string|null $organization_code
     * @param string|null $domain
     * @return static
     */
    public static function create(
        string|null $first_name,
        string|null $last_name,
        string|null $email,
        string|null $contact,
        string|null $dob,
        string|null $city,
        string|null $province,
        string|null $country,
        string|null $organization_name,
        string|null $website,
        string|null $message,
        string|null $bio,
        string|null $no_of_employees,
        string|null $code,
        string|null $organization_code,
        string|null $domain,
    ): self {
        return new self($first_name, $last_name, $email, $contact, $dob , $city , $province , $country , $organization_name , $website , $message , $bio, $no_of_employees , $code , $organization_code,  $domain);
    }


    /**
     * @return string|null
     */
    public function getEmail(): string|null
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): string|null
    {
        return $this->first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): string|null
    {
        return $this->last_name;
    }

    /**
     * @return string|null
     */
    public function getOrganizationName(): string|null
    {
        return $this->organization_name;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): string|null
    {
        return $this->website;
    }

    /**
     * @return string|null
     */
    public function getMessage(): string|null
    {
        return $this->message;
    }

    /**
     * @return string|null
     */
    public function getNoOfEmployees(): string|null
    {
        return $this->no_of_employees;
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
    public function getOrganizationCode(): string|null
    {
        return $this->organization_code;
    }

    /**
     * @return string|null
     */
    public function getDomain(): string|null
    {
        return $this->domain;
    }

    /**
     * @return string|null
     */
    public function getDob(): string|null
    {
        return $this->dob;
    }

    /**
     * @return string|null
     */
    public function getCity(): string|null
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getProvince(): string|null
    {
        return $this->province;
    }

    /**
     * @return string|null
     */
    public function getCountry(): string|null
    {
        return $this->country;
    }

    /**
     * @return string|null
     */
    public function getContact(): string|null
    {
        return $this->contact;
    }

    /**
     * @return string|null
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }


}

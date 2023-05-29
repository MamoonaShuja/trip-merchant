<?php

namespace Modules\User\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\Enum\UserType;
use Modules\User\Entities\User;

interface UserRepositoryContract
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
     * @param array|null $permissions
     * @param UserType $userType
     * @return User
     */
    public function create(

        string $first_name,
        string $last_name,
        string $email,
        ?string $password,
        ?string $code,
        ?string $website,
        ?string $organization_name,
        ?string $no_of_employees,
        ?string $message,
        UserType|string $userType
    ): User;

    /**
     * @param string $strEmail
     * @return User|null
     */
    public function findByEmail(string $strEmail): ?User;

    /**
     * @param User $objUser
     * @param string|null $strName
     * @param string|null $strEmail
     * @param string|null $strPhoneNumber
     * @param string|null $strPassword
     * @return User
     */
    public function updateUser(
        User $objUser,
        ?string $strFirstName = null,
        ?string $strLastName = null,
        ?string $strEmail = null,
        string|null $strContact = null,
        string|null $strDob = null,
        string|null $strCity = null,
        string|null $strProvince = null,
        string|null $strCountry = null,
        ?string $strOrganizationName = null,
        ?string $strWebsite = null,
        ?string $strMessage = null,
        ?string $strNoOfEmployees = null,
        ?string $strCode = null,
        ?string $strOrganizationCode = null,
        ?string $strPassword = null,
        ?string $strBio = null
    ): User;


    /**
     * @param string $id
     * @return User|null
     */
    public function findByUuid(string $id): User|null;

    /**
     * @param string|null $id
     * @return User
     */
    public function findOrganization(string|null $strCode): User;

    /**
     * @param string $userType
     * @return Collection|null
     */
    public function getAll(string $strUserType): ?Collection;

    /**
     * @param User $user
     * @param string $status
     * @return User
     */
    public function updateActiveStatus(User $objUser , string $strStatus , string $strPassword , string|null $strOrganizationCode, string|null $strDomain):User;

    /**
     * @return User
     */
    public function getAdmin():User|null;

    /**
     * @param User $objUser
     * @param array $arrPermissions
     * @return void
     */
    public function savePermissions(User $objUser , array $arrPermissions):void;

    /**
     * @param string $strDomain
     * @return bool
     */
    public function checkDomain(string $strDomain):bool;
}

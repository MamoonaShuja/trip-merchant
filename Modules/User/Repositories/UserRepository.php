<?php

namespace Modules\User\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Mailgun\Exception;
use Modules\Core\Contracts\Repositories\RoleRepositoryContract;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Modules\User\Contracts\Repositories\UserRepositoryContract;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class UserRepository implements UserRepositoryContract
{
    public function __construct(
        private readonly User $model,
        private readonly RoleRepositoryContract $objRoleRepository,

    ) {}

    /**
     * @return User
     */
    public function getAdmin():User|null{

        $objQuery = $this->model->newQuery();

        return $objQuery->whereHas("role" , function ($query) {
            return $query->whereName(UserType::ADMIN->value);
        })->first();
    }
    /**
     * @param string $strEmail
     * @return User|null
     */
    public function findByEmail(string $strEmail): ?User
    {
        $objQuery = $this->model->newQuery();

        return $objQuery->whereEmail($strEmail)->first();
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $referred_by
     * @param UserType $userType
     * @return User
     */
    public function create(

        string      $first_name,
        string      $last_name,
        string      $email,
        string|null $password,
        string|null $code,
        string|null $website,
        string|null $organization_name,
        string|null $no_of_employees,
        string|null $message,
        UserType|string    $userType,
    ): User {
        $objQuery = $this->model->newQuery();
        $approvedStatus  = 1;
        $organizationId  = null;
        if(!is_string($userType)) {
            if ($userType->value == UserType::ORGANIZER->value || $userType->value == UserType::SUPPLIER->value || $userType->value == UserType::EMPLOYEE->value) {
                $approvedStatus = 0;
            }
            if($userType->value == UserType::MEMBER->value){
                $organizationId = $this->findOrganization($code)->id;
            }
        }
        $objUser = $objQuery->create([
            "first_name"      => $first_name,
            "last_name"      => $last_name,
            "email"     => $email,
            "password"  => $password,
            "organization_id"  => $organizationId,
            "website"  => $website != null ? $website : null,
            "organization_name"  => $organization_name != null ? $organization_name : null,
            "no_of_employees"  => $no_of_employees != null ? $no_of_employees : null,
            "message"  => $message != null ? $message : null,
            "is_approved"  => $approvedStatus,
            "role_id" => is_string($userType) ? $this->objRoleRepository->findByUuid($userType)->id : $this->objRoleRepository->getRoleByName($userType->value),
            "user_uuid" => Str::uuid(),
          ]);
        return $objUser;
    }

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
    ): User {
        if (is_string($strFirstName) && $objUser->first_name !== $strFirstName) {
            $objUser->first_name = $strFirstName;
        }
        if (is_string($strLastName) && $objUser->last_name !== $strLastName) {
            $objUser->last_name = $strLastName;
        }

        if (is_string($strEmail) && $objUser->email !== $strEmail) {
            $objUser->email = $strEmail;
            $objUser->email_verified_at = null;
        }
        if (is_string($strContact) && $objUser->contact !== $strContact) {
            $objUser->contact = $strContact;
        }
        if (is_string($strDob) && $objUser->dob !== $strDob) {
            $objUser->dob = $strDob;
        }
        if (is_string($strCity) && $objUser->city !== $strCity) {
            $objUser->city = $strCity;
        }
        if (is_string($strCountry) && $objUser->country !== $strCountry) {
            $objUser->country = $strCountry;
        }
        if (is_string($strProvince) && $objUser->province !== $strProvince) {
            $objUser->province = $strProvince;
        }
        if (is_string($strOrganizationName) && $objUser->organization_name !== $strOrganizationName) {
            $objUser->organization_name = $strOrganizationName;
        }

        if (is_string($strWebsite) && $objUser->website !== $strWebsite) {
            $objUser->website = $strWebsite;
        }
        if (is_string($strMessage) && $objUser->message !== $strMessage) {
            $objUser->message = $strMessage;
        }
        if (is_string($strNoOfEmployees) && $objUser->no_of_employees !== $strNoOfEmployees) {
            $objUser->no_of_employees = $strNoOfEmployees;
        }
        if (is_string($strCode) && $objUser->code !== $strCode) {
            $objUser->code = $strCode;
            $objUser->organization_id = $this->findOrganization($strCode);
        }
        if (is_string($strOrganizationCode) && $objUser->organization_code !== $strOrganizationCode) {
            $objUser->organization_code = $strOrganizationCode;
        }

        if (is_string($strPassword)) {
            $objUser->password = $strPassword;
        }

        $objUser->save();

        return $objUser;
    }

    /**
     * @param string $id
     * @return User|null
     */
    public function findByUuid(string $id): User|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereUserUuid($id)->first();
    }

    /**
     * @param string $code
     * @return User|null
     */
    public function findOrganization(string|null $strCode):User{
        $objQuery = $this->model->newQuery();
        return is_null($strCode) || empty($strCode) ? $objQuery->whereHas('role' , function ($query){
          return $query->whereName(UserType::ORGANIZER->value);
        })->first() : $objQuery->whereOrganizationCode($strCode)->first();
    }


    /**
     * @param string $type
     * @return Collection|null
     */
    public function getAll(string $strUserType): Collection|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereHas('role' , function ($query) use ($strUserType){
            return $query->whereName($strUserType);
        })->get();
    }

    /**
     * @param User $objUser
     * @param string $strStatus
     * @param string $strPassword
     * @param string $strOrganizationCode
     * @param string $strDomain
     * @return User
     */
    public function updateActiveStatus(User $objUser , string $strStatus , string $strPassword , string|null $strOrganizationCode , string|null $strDomain):User{
        if (is_string($strStatus) && $objUser->is_approved !== $strStatus) {
            $objUser->is_approved = $strStatus;
        }
        if (is_string($strPassword)) {
            $objUser->password = $strPassword;
        }
        if (is_string($strOrganizationCode) && $objUser->organization_code !== $strOrganizationCode) {
            $objUser->organization_code = $strOrganizationCode;
        }
        if (is_string($strDomain) && $objUser->domain !== $strDomain) {
            $objUser->domain = $strDomain;
        }

        $objUser->save();
        return $objUser;
    }


    public function savePermissions(User $objUser, array $arrPermissions): void
    {
        $objUser->permissions()->sync($arrPermissions);
    }

    /**
     * @param string $strDomain
     * @return bool
     */
    public function checkDomain(string $strDomain): bool{
        $objQuery = $this->model->newQuery();
        return $objQuery->whereDomain($strDomain)->count() > 0 ? true : false;
    }
}

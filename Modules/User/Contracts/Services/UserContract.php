<?php

namespace Modules\User\Contracts\Services;

use Modules\Admin\DataTransfer\Requests\UpdateUserStatusDTO;
use Modules\User\DataTransfer\Requests\ForgetPasswordDTO;
use Modules\User\DataTransfer\Requests\ResetPasswordDTO;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Modules\User\DataTransfer\Requests\SignUpDTO;
use Modules\User\DataTransfer\Requests\UpdateUserDTO;
use \Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UserContract {
    /**
     * @param SignUpDTO $signUpDTO
     * @param UserType|string $objType
     * @return User
     */
    public function create(SignUpDTO $signUpDTO, UserType|string $objType): User;

    /**
     * @param string $strEmail
     * @return User|null
     */
    public function findByEmail(string $strEmail): User|null;

    /**
     * @param User $objUser
     * @param string $strPassword
     * @return bool
     */
    public function checkUserPassword(User $objUser, string $strPassword): bool;

    /**
     * @param User $objUser
     * @param UpdateUserDTO $updateUserDTO
     * @return User
     */
    public function edit(User $objUser, UpdateUserDTO $updateUserDTO): User;

    /**
     * @param User $objUser
     * @param string $strNewPassword
     * @return User
     */
    public function changePassword(User $objUser, string $strNewPassword): User;

    /**
     * @param ForgetPasswordDTO $forgetPasswordDTO
     * @return bool
     */
    public function forgetPassword(ForgetPasswordDTO $forgetPasswordDTO): bool;

    /**
     * @param ResetPasswordDTO $resetPasswordDTO
     * @return bool
     */
    public function resetPassword(ResetPasswordDTO $resetPasswordDTO): bool;

    /**
     * @param User $objUser
     * @param UploadedFile $avatar
     * @return User
     */
    public function uploadAvatar(User $objUser, UploadedFile $avatar): User;

    /**
     * @param int $id
     * @return User
     */
    public function findByUuid(string $id): User|null;

    /**
     * @param string $userType
     * @return Collection|null
     */
    public function getAllUsers(string $userType):?Collection;
    /**
     * @param User $user
     * @param string $status
     * @return User
     */
    public function updateActiveStatus(User $user , UpdateUserStatusDTO $updateStatusDTO):User;

    /**
     * @param User $objUser
     * @param string $strAbout
     * @return User
     */
    public function updateAbout(User $objUser, string $strAbout): User;

    /**
     * @param string $strDomain
     * @return bool
     */
    public function checkDomain(string $strDomain): bool;

    /**
     * @param string|null $strCode
     * @return User
     */
    public function findOrganization(string|null $strCode):User;
}

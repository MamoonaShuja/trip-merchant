<?php

namespace Modules\User\Services;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Modules\Admin\DataTransfer\Requests\UpdateUserStatusDTO;
use Modules\Core\Helpers\CloudinaryFileSystem\UploadFilesystem;
use Modules\Core\Notifications\EmailNotification;
use Modules\Tour\Enum\MediaTypes;
use Modules\User\Constants\UserFiles;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Modules\User\Contracts\Repositories\UserRepositoryContract;
use Modules\User\Contracts\Services\AccessTokenContract;
use Modules\User\DataTransfer\Requests\ForgetPasswordDTO;
use Modules\User\DataTransfer\Requests\ResetPasswordDTO;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Illuminate\Support\Facades\Hash;
use Modules\User\Repositories\UserRepository;
use Modules\User\Contracts\Services\UserContract;
use Modules\User\DataTransfer\Requests\SignUpDTO;
use Modules\User\DataTransfer\Requests\UpdateUserDTO;
use Modules\Core\Contracts\Services\Filesystem\FilesystemContract;

final class UserService implements UserContract
{
    /**
     * @param AccessTokenContract $objTokenService
     * @param FilesystemContract $objFilesystemContract
     * @param UserRepository $objUserRepository
     */
    public function __construct(
        //Services
        private readonly AccessTokenContract    $objTokenService,
        private readonly FilesystemContract     $objFilesystemContract,
        //Repositories
        private readonly UserRepositoryContract $objUserRepository,
    )
    {
    }

    /**
     * @param SignUpDTO $signUpDTO
     * @param UserType $objType
     * @return User
     * @throws \Exception
     */
    public function create(SignUpDTO $signUpDTO, UserType|string $objType): User
    {
        $objUser = $this->objUserRepository->create(
            $signUpDTO->getFirstName(),
            $signUpDTO->getLastName(),
            $signUpDTO->getEmail(),
            Hash::make($signUpDTO->getPassword()),
            $signUpDTO->getCode(),
            $signUpDTO->getWebsite(),
            $signUpDTO->getOrganizationName(),
            $signUpDTO->getNoOfEmployees(),
            $signUpDTO->getMessage(),
            $objType
        );
        if ($objUser->role->name == UserType::ORGANIZER->value || $objUser->role->name == UserType::SUPPLIER->value) {
            $subject = "New Account Register";
            $message = "New Account has been register please approve";
            $admin = $this->objUserRepository->getAdmin();
            $admin->notify(new EmailNotification($subject, $message));
        }

        if (!is_null($signUpDTO->getAvatar()))
            $this->saveAvatar($signUpDTO->getAvatar(), $objUser);
        return $objUser;
    }

    public function findByEmail(string $strEmail): User|null
    {
        return $this->objUserRepository->findByEmail($strEmail);
    }

    public function checkUserPassword(User $objUser, string $strPassword): bool
    {
        return Hash::check($strPassword, $objUser->password);
    }

    /**+
     *
     * @param User $objUser
     * @param UpdateUserDTO $updateUserDTO
     * @return User
     */
    public function edit(User $objUser, UpdateUserDTO $updateUserDTO): User
    {
        return $this->objUserRepository->updateUser(
            $objUser,
            $updateUserDTO->getFirstName(),
            $updateUserDTO->getLastName(),
            $updateUserDTO->getEmail(),
            $updateUserDTO->getContact(),
            $updateUserDTO->getDob(),
            $updateUserDTO->getCity(),
            $updateUserDTO->getProvince(),
            $updateUserDTO->getCountry(),
            $updateUserDTO->getCode(),
            $updateUserDTO->getWebsite(),
            $updateUserDTO->getOrganizationName(),
            $updateUserDTO->getNoOfEmployees(),
            $updateUserDTO->getMessage(),
            $updateUserDTO->getBio(),
        );
    }

    /**
     * @param User $objUser
     * @param string $strNewPassword
     * @return User
     * @throws \Throwable
     */
    public function changePassword(User $objUser, string $strNewPassword): User
    {
        return DB::transaction(function () use ($objUser, $strNewPassword): User {
            $objUser = $this->objUserRepository->updateUser(
                objUser: $objUser,
                strPassword: Hash::make($strNewPassword)
            );

            $this->objTokenService->revokeToken(
                objToken: $this->objTokenService->getCurrentToken($objUser)
            );

            return $objUser;
        });
    }

    /**
     * @param ForgetPasswordDTO $forgetPasswordDTO
     * @return bool
     */
    public function forgetPassword(ForgetPasswordDTO $forgetPasswordDTO): bool
    {
        $status = Password::sendResetLink(
            ['email' => $forgetPasswordDTO->getEmail()]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return true;
        }

        return false;
    }

    /**
     * @param ResetPasswordDTO $resetPasswordDTO
     * @return bool
     */
    public function resetPassword(ResetPasswordDTO $resetPasswordDTO): bool
    {
        $status = Password::reset([
            'email' => $resetPasswordDTO->getEmail(),
            'password' => $resetPasswordDTO->getPassword(),
            'password_confirmation' => $resetPasswordDTO->getPasswordConfirmation(),
            'token' => $resetPasswordDTO->getToken()
        ], function (User $user, string $password) {
            $this->objUserRepository->updateUser($user, strPassword: Hash::make($password));
            event(new PasswordReset($user));
        });

        if ($status === Password::PASSWORD_RESET) {
            return true;
        }

        return false;
    }

    private function getDefaultAvatar(): string
    {
        $arrFiles = $this->objFilesystemContract->files(UserFiles::DEFAULT_AVATARS_DIR);
        if (empty($arrFiles)) {
            throw new \Exception("Invalid Avatars.");
        }

        return Arr::random($arrFiles);
    }

    /**
     * @param User $objUser
     * @return User
     * @throws \Exception
     */
    private function saveDefaultAvatar(User $objUser): User
    {
        return $this->saveAvatar(storage_path($this->getDefaultAvatar()), $objUser);
    }

    private function saveAvatar(UploadedFile|string $avatarPath, User $objUser): User
    {
        if (is_string($avatarPath)) {
            $strPath = sprintf(UserFiles::USER_AVATAR_FULL_NAME, $objUser->id);
        } else {
            $strPath = sprintf(UserFiles::USER_AVATAR_FILE_PATH, $objUser->id);
        }
        UploadFilesystem::uploadImage($objUser, $strPath, MediaTypes::FEATURED->value, $avatarPath);
        return $objUser;
    }


    /**
     * @param User $objUser
     * @param UploadedFile $avatar
     * @return User
     */
    public function uploadAvatar(User $objUser, UploadedFile $avatar): User
    {
        return $this->saveAvatar($avatar, $objUser);
    }

    /**
     * @param int $id
     * @return User
     */
    public function findByUuid(string $id): User|null
    {
        return $this->objUserRepository->findByUuid($id);
    }

    /**
     * @param string $userType
     * @return Collection|null
     */
    public function getAllUsers(string $userType): Collection|null
    {
        return $this->objUserRepository->getAll($userType);
    }

    /**
     * @param User $user
     * @param string $status
     * @return bool
     */
    public function updateActiveStatus(User $user, UpdateUserStatusDTO $userUpdateStatusRequest): User
    {
        $objUser = $this->objUserRepository->updateActiveStatus(
            $user,
            $userUpdateStatusRequest->getStatus(),
            Hash::make($userUpdateStatusRequest->getPassword()),
            $userUpdateStatusRequest->getOrganizationCode(),
            $userUpdateStatusRequest->getDomain(),
        );
        $subject = "Account Activation Status";
        if ($userUpdateStatusRequest->getStatus() == 1) {
            $objUser->admin_message = null;
            $message = "Your account has been activated and your password is <br><strong>"
                . $userUpdateStatusRequest->getPassword() .
                "</strong> and you can login to your admin panel by visiting" . env("PORTAL_URL") . "
                 and selecting organization. Your travel site link is
                 <a href='" . $userUpdateStatusRequest->getDomain() . "." . env('FRONTEND_URL') . "' >" . $userUpdateStatusRequest->getDomain() . "." . env('FRONTEND_URL') . "</a>
                and your organization code is <strong>" . $userUpdateStatusRequest->getOrganizationCode() . "</strong>";
        } else {
            $objUser->admin_message = $userUpdateStatusRequest->getAdminMessage();
//            $message = "Sorry! Your Account Has not been approved";
            $message = $userUpdateStatusRequest->getAdminMessage();
        }
        $objUser->save();
        $objUser->notify(new EmailNotification($subject, $message));
        return $objUser;
    }

    public function updateAbout(User $objUser, string $strAbout): User
    {
        return $this->objUserRepository->updateUser(
            objUser: $objUser,
            strBio: $strAbout
        );
    }

    /**
     * @param string $strDomain
     * @return bool
     */
    public function checkDomain(string $strDomain): bool
    {
        return $this->objUserRepository->checkDomain($strDomain);
    }

    /**
     * @param string|null $strCode
     * @return User
     */
    public function findOrganization(string|null $strCode): User
    {
        return $this->objUserRepository->findOrganization($strCode);
    }

}

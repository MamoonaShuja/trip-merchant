<?php

namespace Modules\Supplier\Http\Controllers;

use Modules\Supplier\Http\Requests\UploadLogoRequest;
use Modules\User\Entities\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Modules\User\Contracts\Services\UserContract;
use Modules\User\Http\Requests\UploadAvatarRequest;
use Psr\Container\NotFoundExceptionInterface;
use Modules\Core\Transformers\UserTransformer;
use Psr\Container\ContainerExceptionInterface;
use Modules\User\Http\Requests\UserUpdateRequest;
use Modules\User\Http\Requests\ChangePasswordRequest;
use Modules\User\Exceptions\PasswordMismatchException;
use Illuminate\Contracts\Container\BindingResolutionException;

final class UserController extends Controller
{
    public function __construct(
        private readonly UserContract $objUserService
    ) {}

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getAuthUser(): JsonResponse
    {
        /** @var User $objUser */
        $objUser = Auth::user();
        return apiResponse()->success(new UserTransformer($objUser));
    }

    /**
     * @param UserUpdateRequest $objRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateAuthUser(UserUpdateRequest $objRequest): JsonResponse
    {
        /** @var User $objUser */
        $objUser = Auth::user();

        $objUser = $this->objUserService->edit($objUser, $objRequest->getDTO());

        return apiResponse()->success(new UserTransformer($objUser));
    }

    /**
     * @param ChangePasswordRequest $objRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws PasswordMismatchException|ValidationException
     */
    public function changePassword(ChangePasswordRequest $objRequest): JsonResponse
    {
        /** @var User $objUser */
        $objUser = Auth::user();

        $objDTO = $objRequest->getDTO();

        if ($this->objUserService->checkUserPassword($objUser, $objDTO->getCurrentPassword()) === false) {
            throw ValidationException::withMessages([
                'current_password' => ["Your Current Password Doesn't Match With Provided."],
            ]);
        }

        $this->objUserService->changePassword($objUser, $objDTO->getNewPassword());

        return apiResponse()->logout()->success("You Have Successfully Updated Your Password.");
    }

    /**
     * @param UploadAvatarRequest $uploadAvatarRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function uploadAvatar(UploadAvatarRequest $uploadAvatarRequest): JsonResponse{
        $objDTO = $uploadAvatarRequest->getDTO();

        /** @var User $objUser */
        $objUser = Auth::user();

        $this->objUserService->uploadAvatar($objUser, $objDTO->getAvatar());

        return apiResponse()->success("You Have Successfully Updated Your Image.");
    }

    /**
     * @param UploadAvatarRequest $uploadAvatarRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function uploadLogo(UploadLogoRequest $uploadLogoRequest): JsonResponse{
        $objDTO = $uploadLogoRequest->getDTO();

        /** @var User $objUser */
        $objUser = Auth::user();

        $objUser->uploadLogo($objDTO->getAvatar());

        return apiResponse()->success("You Have Successfully Updated Logo.");
    }

    public function updateAboutUs(UserUpdateRequest $objRequest){
        /** @var User $objUser */
        $objUser = Auth::user();
        $objUser = $this->objUserService->updateAbout($objUser, $objRequest->getDTO()->getMessage());

        return apiResponse()->success(new UserTransformer($objUser));
    }
}

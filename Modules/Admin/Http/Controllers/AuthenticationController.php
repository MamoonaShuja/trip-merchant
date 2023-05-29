<?php

namespace Modules\Admin\Http\Controllers;

use Modules\User\Contracts\Services\UserContract;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Modules\User\Contracts\Services\AccessTokenContract;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\Core\Transformers\UserTransformer;
use Modules\User\Enum\UserType;
use Modules\User\Http\Requests\Authentication\ForgetPasswordRequest;
use Modules\User\Http\Requests\Authentication\ResetPasswordRequest;
use Modules\User\Http\Requests\Authentication\SignInRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

final class AuthenticationController extends Controller
{
    /**
     * @param UserContract $objUserService
     * @param AccessTokenContract $objTokenService
     */
    public function __construct(
        private readonly UserContract $objUserService,
        private readonly AccessTokenContract $objTokenService
    ) {}

    /**
     * @param SignInRequest $objRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ValidationException
     */
    public function signIn(SignInRequest $objRequest): JsonResponse
    {
        $objDTO = $objRequest->getDTO();

        $objUser = $this->objUserService->findByEmail($objDTO->getEmail());

        if (is_null($objUser)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        if($objUser->role->name != UserType::ADMIN->value){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        };
        if ($this->objUserService->checkUserPassword($objUser, $objDTO->getPassword()) === false) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $strToken = $this->objTokenService->createAuthToken($objUser);

        return apiResponse()->meta("token", $strToken)->success(new UserTransformer($objUser));
    }

    /**
     * @param ForgetPasswordRequest $forgetPasswordRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function forgetPassword(ForgetPasswordRequest $forgetPasswordRequest): JsonResponse
    {
        $forgetPasswordDTO = $forgetPasswordRequest->getDTO();
        $result = $this->objUserService->forgetPassword($forgetPasswordDTO);
        $objUser = $this->objUserService->findByEmail($forgetPasswordDTO->getEmail());
        $strToken = $this->objTokenService->createAuthToken($objUser);

        return apiResponse()->meta("token", $strToken)->success($result);
    }

    /**
     * @param ResetPasswordRequest $resetPasswordRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function resetPassword(ResetPasswordRequest $resetPasswordRequest): JsonResponse
    {
        $result = $this->objUserService->resetPassword($resetPasswordRequest->getDTO());
        $objUser = $this->objUserService->findByEmail($resetPasswordRequest->getDTO()->getEmail());
        $strToken = $this->objTokenService->createAuthToken($objUser);

        return apiResponse()->meta("token", $strToken)->success($result);
    }

}

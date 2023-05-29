<?php

namespace Modules\Organizer\Http\Controllers;

use Modules\Organizer\Http\Requests\Authentication\OrganizerSignUpRequest;
use Modules\User\Contracts\Services\UserContract;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Modules\User\Contracts\Services\AccessTokenContract;
use Modules\User\Enum\UserType;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\Core\Transformers\UserTransformer;
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
     * @param OrganizerSignUpRequest $objRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function signUp(OrganizerSignUpRequest $objRequest): JsonResponse
    {
        $objUser = $this->objUserService->create($objRequest->getDTO(), UserType::ORGANIZER);
        return apiResponse()->success(new UserTransformer($objUser));
    }

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

        if($objUser->role->name != UserType::ORGANIZER->value){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (is_null($objUser)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

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
        $objUser = $this->objUserService->findByEmail($forgetPasswordDTO->getEmail());
        if(is_null($objUser))
            throw ValidationException::withMessages([
                'email' => ["This email doesn't exist in our system"],
            ]);
        $result = $this->objUserService->forgetPassword($forgetPasswordDTO);
        if(!$objUser->is_approved)
            throw ValidationException::withMessages([
                'approval' => ['Your account has not approved.'],
            ]);
        return apiResponse()->success($result);
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
        $objUser = $this->objUserService->findByEmail($resetPasswordRequest->getDTO()->getEmail());
        if(is_null($objUser))
            throw ValidationException::withMessages([
                'email' => ["This email doesn't exist in our system"],
            ]);
        $result = $this->objUserService->resetPassword($resetPasswordRequest->getDTO());
        if(!$objUser->is_approved)
            throw ValidationException::withMessages([
                'approval' => ['Your account has not approved.'],
            ]);
        return apiResponse()->success($result);
    }

}

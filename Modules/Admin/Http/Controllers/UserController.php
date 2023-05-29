<?php

namespace Modules\Admin\Http\Controllers;

use Intervention\Image\Exception\NotFoundException;
use Modules\Admin\Http\Requests\CreateAdminRequest;
use Modules\Admin\Http\Requests\UserUpdateStatusRequest;
use Modules\Core\Exceptions\Validation\ValidationException;
use Modules\User\Entities\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\User\Contracts\Services\UserContract;
use Modules\User\Enum\UserType;
use Psr\Container\NotFoundExceptionInterface;
use Modules\Core\Transformers\UserTransformer;
use Psr\Container\ContainerExceptionInterface;
use Modules\User\Http\Requests\UserUpdateRequest;
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
    public function getAll(string $type = null): JsonResponse
    {

        if($type == null):
            $currentUrl = explode("/" , url()->current());
            $type = $currentUrl[sizeof($currentUrl)-1];
        endif;
        $objUsers = $this->objUserService->getAllUsers($type);
        return apiResponse()->success(UserTransformer::collection($objUsers));
    }

    /**
     * @param string $uuid
     * @param UserUpdateStatusRequest $userUpdateStatusRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateStatus(string $uuid , UserUpdateStatusRequest $userUpdateStatusRequest): JsonResponse
    {
        $objUser = $this->objUserService->findByUuid($uuid);
        if($objUser == null){
            throw new NotFoundException(
                "Invalid UUid"
            );
        }
        $objUser = $this->objUserService->updateActiveStatus($objUser , $userUpdateStatusRequest->getDTO());
        return apiResponse()->success(new UserTransformer($objUser));
    }

    public function createAdmin(CreateAdminRequest $createAdminRequest){
        $objUser = $this->objUserService->create($createAdminRequest->getDTO(), $createAdminRequest->getDTO()->getRole());
        return apiResponse()->success(new UserTransformer($objUser));
    }

}

<?php

namespace Modules\User\Http\Controllers;

use Modules\Core\Transformers\SubscriberTransformer;
use Modules\User\Contracts\Services\SubscriberContract;
use Modules\User\Entities\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Modules\User\Contracts\Services\UserContract;
use Modules\User\Http\Requests\SubscribeRequest;
use Modules\User\Http\Requests\UploadAvatarRequest;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Modules\User\Http\Requests\ChangePasswordRequest;
use Modules\User\Exceptions\PasswordMismatchException;
use Illuminate\Contracts\Container\BindingResolutionException;

final class SubscriberController extends Controller
{
    public function __construct(
        private readonly UserContract $objUserService,
        private readonly SubscriberContract $objSubscriberService
    ) {}

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function subscribe(SubscribeRequest $subscribeRequest): JsonResponse
    {
        /** @var User $objUser */
        $organization = $subscribeRequest->getDTO()->getOrganizationUuid() != null ?
            $this->objUserService->findByUuid($subscribeRequest->getDTO()->getOrganizationUuid()):
            $this->objUserService->findOrganization(null);
        $objSubscriber = $this->objSubscriberService->create($organization , $subscribeRequest->getDTO());
        return apiResponse()->success(new SubscriberTransformer($objSubscriber));
    }

    /**
     * @param ChangePasswordRequest $objRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws PasswordMismatchException|ValidationException
     */
    public function unSubscribe(string $uuid): JsonResponse
    {
        $objSubscriber = $this->objSubscriberService->findByUuid($uuid);
        is_null($objSubscriber) ?
            throw ValidationException::withMessages([
                'subscription' => ["You are not subscribed"],
            ])
            : $this->objSubscriberService->delete($objSubscriber);

        return apiResponse()->success("You Have Successfully Unsubscribed.");
    }

    /**
     * @param UploadAvatarRequest $uploadAvatarRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getSubscribers(string $organization_uuid = null): JsonResponse{
        /** @var User $objUser */
        $organization = null;
        if($organization_uuid != null)
            $organization = $this->objUserService->findByUuid($organization_uuid);
        $subscribers = $this->objSubscriberService->getAll($organization);

        return apiResponse()->success(SubscriberTransformer::collection($subscribers));
    }
}

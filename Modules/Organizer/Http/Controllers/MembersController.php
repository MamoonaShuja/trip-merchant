<?php

namespace Modules\Organizer\Http\Controllers;

use Cloudinary\Api\UploadApiClient;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Exception\NotFoundException;
use Modules\Admin\Http\Requests\UserUpdateStatusRequest;
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

final class MembersController extends Controller
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
    public function getMembers(): JsonResponse
    {
        /**
         * @var User $organization The User instance.
         */
        $organization = Auth::user();
        return apiResponse()->success(UserTransformer::collection($organization->members));
    }

}

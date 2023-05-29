<?php

namespace Modules\Tour\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Intervention\Image\Exception\NotFoundException;
use Modules\Tour\Contracts\Services\TourContract;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Http\Requests\TourRequest;
use Modules\Tour\Http\Requests\UpdateCabinDeckRequest;
use Modules\Tour\Http\Requests\UpdateGalleryRequest;
use Modules\Tour\Http\Requests\UpdateTourRequest;
use Modules\Tour\Transformers\TourTransformer;
use Modules\User\Contracts\Services\UserContract;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TourController extends Controller
{

    public function __construct(
        private readonly TourContract $objTourService,
        private readonly UserContract $objUserService
    )
    {
    }

    /**
     * Display a listing of the resource.
     * @param TourRequest $objTourRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(TourRequest $objTourRequest): JsonResponse
    {
        $objUser = Auth::user();
        /** @var User $objUser */
        $objTour = $this->objTourService->create($objUser, $objTourRequest->getDTO());
        return apiResponse()->success(new TourTransformer($objTour));
    }

    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getAll(Request $objRequest): JsonResponse
    {
        $objUser = Auth::user();
        /** @var User $objUser */
        $objTours = $this->objTourService->get($objUser);
        return apiResponse()->pagination($objTours)->success(TourTransformer::collection($objTours));
    }

    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getForOrganization(string $uuid = null): JsonResponse
    {
        if (is_null($uuid)) {
            $objUser = Auth::user();
            /** @var User $objUser */
            $objTours = $this->objTourService->get($objUser);
        } else {
            $objOrg = $this->objUserService->findByUuid($uuid);
            if (is_null($objOrg)) {
                throw new ModelNotFoundException(
                    "Invalid Organization"
                );
            } elseif ($objOrg->role->name != UserType::ORGANIZER->value) {
                throw new ModelNotFoundException(
                    "Invalid Organization"
                );
            }
            if (count($objOrg->tours) == 0) {
                return $this->getForOrganization();
            }
            $objTours = new LengthAwarePaginator($objOrg->tours->toArray(), count($objOrg->tours), env("PER_PAGE_TOURS"));
        }

        return apiResponse()->pagination($objTours)->success(TourTransformer::collection($objTours));
    }

    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getWithDeals(): JsonResponse
    {
        $objUser = Auth::user();
        /** @var User $objUser */
        $objTours = $this->objTourService->getWithDeals($objUser);
        return apiResponse()->pagination($objTours)->success(TourTransformer::collection($objTours));
    }

    /**
     * @param string $uuid
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get(string $uuid, Request $objRequest): JsonResponse
    {
        $objTour = $this->objTourService->findByUuid($uuid);

        return is_null($objTour) ?
            throw new NotFoundException(
                "Invalid Trip"
            ) : apiResponse()->success(new TourTransformer($objTour));
    }

    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDeleted(): JsonResponse
    {
        $objTours = $this->objTourService->getDeleted();
        return apiResponse()->pagination($objTours)->success(TourTransformer::collection($objTours));
    }

    /**
     * @param string $uuid
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function delete(string $uuid): JsonResponse
    {
        $objUser = Auth::user();
        /** @var User $objUser */
        $objTour = $this->objTourService->findByUuid($uuid);
        if (is_null($objTour)) {
            throw new NotFoundException(
                "Invalid Trip"
            );
        } else {
            if ($objTour->supplier_id == $objUser->id || $objUser->role->name == UserType::ADMIN->value) {
                $this->objTourService->delete($objTour);
                return apiResponse()->success("Trip has been deleted");
            } else {
                throw new UnauthorizedException(
                    "You are not allowed to delete this trip"
                );
            }
        }
    }

    /**
     * @param string $uuid
     * @param UpdateTourRequest $objTourRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(string $uuid, UpdateTourRequest $objTourRequest): JsonResponse
    {
        $objUser = Auth::user();
        /** @var User $objUser */
        $objTour = $this->objTourService->findByUuid($uuid);
        if (is_null($objTour)) {
            throw new NotFoundException(
                "Invalid Trip"
            );
        } else {
            if ($objTour->supplier_id == $objUser->id || $objUser->role->name == UserType::ADMIN->value) {
                $this->objTourService->update($objTour, $objTourRequest->getDTO());
                return apiResponse()->success(new TourTransformer($objTour));
            } else {
                throw new UnauthorizedException(
                    "You are not allowed to update this trip"
                );
            }
        }
    }

    /**
     * @param string $uuid
     * @param UpdateGalleryRequest $objUpdateGalleryRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateGallery(string $uuid, UpdateGalleryRequest $objUpdateGalleryRequest): JsonResponse
    {
        $objUser = Auth::user();
        /** @var User $objUser */
        $objTour = $this->objTourService->findByUuid($uuid);
        if (is_null($objTour)) {
            throw new NotFoundException(
                "Invalid Trip"
            );
        } else {
            if ($objTour->supplier_id == $objUser->id || $objUser->role->name == UserType::ADMIN->value) {
                $this->objTourService->saveGallery($objTour, $objUpdateGalleryRequest->getDTO()->getUploadedFiles());
                return apiResponse()->success(new TourTransformer($objTour));
            } else {
                throw new UnauthorizedException(
                    "You are not allowed to update this trip"
                );

            }
        }
    }

    /**
     * @param string $uuid
     * @param UpdateCabinDeckRequest $objUpdateCabinDeckRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateSlider(string $uuid, UpdateCabinDeckRequest $objUpdateCabinDeckRequest): JsonResponse
    {
        $objUser = Auth::user();
        /** @var User $objUser */
        $objTour = $this->objTourService->findByUuid($uuid);
        if (is_null($objTour)) {
            throw new NotFoundException(
                "Invalid Trip"
            );
        } else {
            if ($objTour->supplier_id == $objUser->id || $objUser->role->name == UserType::ADMIN->value) {
                $this->objTourService->saveSlider($objTour, $objUpdateCabinDeckRequest->getDTO()->getUploadedFiles());
                return apiResponse()->success(new TourTransformer($objTour));
            } else {
                throw new UnauthorizedException(
                    "You are not allowed to update this trip"
                );

            }
        }
    }


    /**
     * @param string $uuid
     * @param string $type
     * @param string $mediaId
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function deleteFile(string $uuid, string $type, string $mediaId): JsonResponse
    {
        $objUser = Auth::user();
        /** @var User $objUser */
        $objTour = $this->objTourService->findByUuid($uuid);
        if (is_null($objTour)) {
            throw new NotFoundException(
                "Invalid Trip"
            );
        } else {
            if ($objTour->supplier_id == $objUser->id || $objUser->role->name == UserType::ADMIN->value) {
                $objTour->detachMediaById($type, $mediaId);
                return apiResponse()->success("File Deleted Successfully");
            } else {
                throw new UnauthorizedException(
                    "You are not allowed to delete"
                );
            }
        }

    }

}

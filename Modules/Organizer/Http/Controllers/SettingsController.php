<?php

namespace Modules\Organizer\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Organizer\Contracts\Services\OrganizationSliderContract;
use Modules\Organizer\Contracts\Services\SettingsContract;
use Modules\Organizer\Http\Requests\UpdateSettingsRequest;
use Modules\Organizer\Http\Requests\UpdateSliderRequest;
use Modules\Organizer\Transformers\OrganizerSliderTransformer;
use Modules\Organizer\Transformers\SettingsTransformer;
use Modules\User\Contracts\Services\UserContract;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use stdClass;

final class SettingsController extends Controller
{
    public function __construct(
        private readonly SettingsContract $objSettingsService,
        private readonly UserContract $objUserService,
        private readonly OrganizationSliderContract $objOrganizationSliderService,
    ) {}

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateSettings(UpdateSettingsRequest $updateSettingsRequest): JsonResponse
    {
        /** @var User|Auth $objUser */
        $objUser = Auth::user();
        $meta = $this->objSettingsService->updateSettings($objUser , $updateSettingsRequest->getDTO());
        return apiResponse()->success(new SettingsTransformer($meta));
    }

    /**
     * @param string $strUuid
     * @param UpdateSliderRequest $updateSliderRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateSlider(string $strUuid , UpdateSliderRequest $updateSliderRequest): JsonResponse
    {
        $objSlider = $this->objOrganizationSliderService->getSliderByUuid($strUuid);
        if(is_null($objSlider)){
            throw new ModelNotFoundException(
                "Invalid Slider"
            );
        }
        $objSlider = $this->objOrganizationSliderService->updateSlider($objSlider , $updateSliderRequest->getDTO());
        return apiResponse()->success(new OrganizerSliderTransformer($objSlider));
    }

    /**
     * @param string $strUuid
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function deleteSlider(string $strUuid): JsonResponse
    {
        $objSlider = $this->objOrganizationSliderService->getSliderByUuid($strUuid);
        if(is_null($objSlider)){
            throw new ModelNotFoundException(
                "Invalid Slider"
            );
        }
        $this->objOrganizationSliderService->deleteSlider($objSlider);
        return apiResponse()->success("Slider has been deleted");
    }
    public function settings(string $uuid = null): JsonResponse
    {
        /** @var User|Auth $objOrg */
            if(!is_null($uuid)){
                $objOrg = $this->objUserService->findByUuid($uuid);
                if(is_null($objOrg)){
                    throw new ModelNotFoundException(
                        "Invalid Organization"
                    );
                }elseif($objOrg->role->name != UserType::ORGANIZER->value){
                    throw new ModelNotFoundException(
                        "Invalid Organization"
                    );
                }
            }else {
                $objOrg = Auth::user();
                if($objOrg->role->name != UserType::ORGANIZER->value){
                    throw new ModelNotFoundException(
                        "Invalid Organization"
                    );

            }
        }
        return apiResponse()->success(new SettingsTransformer($objOrg->settings));
    }

}

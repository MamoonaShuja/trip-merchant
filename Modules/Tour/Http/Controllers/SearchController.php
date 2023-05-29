<?php

namespace Modules\Tour\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Tour\Contracts\Services\SearchContract;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Http\Requests\GeneralFilterRequest;
use Modules\Tour\Http\Requests\GuidedTourFilterRequest;
use Modules\Tour\Http\Requests\OceanCruisesFilterRequest;
use Modules\Tour\Transformers\TourTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SearchController extends Controller
{

    public function __construct(
        private readonly SearchContract $objSearchContract,
        private readonly Tour           $tourModel
    )
    {
    }

    /**
     * Display a listing of the resource.
     * @param GeneralFilterRequest $generalFilterRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function generalFilter(GeneralFilterRequest $generalFilterRequest): JsonResponse
    {
        $objTours = $this->objSearchContract->generalFilter($generalFilterRequest->getDTO());
        return apiResponse()->pagination($objTours)->success(TourTransformer::collection($objTours));
    }

    /**
     * @param GuidedTourFilterRequest $guidedTourFilterRequest
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function guidedTourFilter(GuidedTourFilterRequest $guidedTourFilterRequest): JsonResponse
    {
        $objTours = $this->objSearchContract->guidedTourFilter($guidedTourFilterRequest->getDTO());
        return apiResponse()->pagination($objTours)->success(TourTransformer::collection($objTours));
    }
}

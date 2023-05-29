<?php

namespace Modules\Tour\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Tour\Contracts\Services\TravelStyleContract;
use Modules\Tour\Enum\MediaTypes;
use Modules\Tour\Enum\TravelStyleTypes;
use Modules\Tour\Http\Requests\CreateTravelStyleRequest;
use Modules\Tour\Http\Requests\UpdateTravelStyleRequest;
use Modules\Tour\Transformers\TravelStyleTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TravelStyleController extends Controller
{
    public function __construct(
        private readonly TravelStyleContract $objTravelStyleService
    ) {}


    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getTravelStyles():JsonResponse
    {
        $travelStyles = $this->objTravelStyleService->get();
        return apiResponse()->success(TravelStyleTransformer::collection($travelStyles));
    }



    /**
     * @param CreateTravelStyleRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function store(CreateTravelStyleRequest $request): JsonResponse
    {
        $objTravelStyle= $this->objTravelStyleService->create($request->getDTO());
        return apiResponse()->success(new TravelStyleTransformer($objTravelStyle));
    }

    /**
     * Show the specified resource.
     * @param string $id
     * @return Renderable
     */
    public function getById(string $id): JsonResponse
    {
        $objTravelStyle = $this->objTravelStyleService->findByUuid($id);

        if (is_null($objTravelStyle)) {
            throw new \Exception("travel style Not Found.", 404);
        }

        return apiResponse()->success(new TravelStyleTransformer($objTravelStyle));
    }


    /**
     * @param string $id
     * @param UpdateTravelStyleRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(string $id , UpdateTravelStyleRequest $request): JsonResponse
    {

        $travelStyle = $this->objTravelStyleService->findByUuid($id);
        if (is_null($travelStyle)) {
            throw new \Exception("Travel Style Not Found.", 404);
        }
        $objTravelStyle = $this->objTravelStyleService->update($travelStyle , $request->getDTO());
        return apiResponse()->success(new TravelStyleTransformer($objTravelStyle));
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return Renderable
     */
    public function destroy($id):JsonResponse
    {
        $objTravelStyle= $this->objTravelStyleService->findByUuid($id);
        if (is_null($objTravelStyle)) {
            throw new \Exception("travel style Not Found.", 404);
        }
        $objTravelStyle->detachMedia(MediaTypes::FEATURED->value);
        $objTravelStyle->detachMedia(MediaTypes::SLIDER->value);
        $this->objTravelStyleService->delete($objTravelStyle);
        return apiResponse()->success("travel style has been deleted");
    }
}

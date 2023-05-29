<?php

namespace Modules\Tour\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Tour\Contracts\Services\CityContract;
use Modules\Tour\Contracts\Services\CountryContract;
use Modules\Tour\Http\Requests\CreateCityRequest;
use Modules\Tour\Http\Requests\UpdateCityRequest;
use Modules\Tour\Transformers\CityTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psy\Util\Json;

class CityController extends Controller
{
    public function __construct(
        private readonly CityContract $objCityService,
        private readonly CountryContract $objCountryService
    ) {}


    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCities():JsonResponse
    {
        $cities = $this->objCityService->get();
        return apiResponse()->success(CityTransformer::collection($cities));
    }



    /**
     * @param CreateCityRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function store(CreateCityRequest $request): JsonResponse
    {
        $objDto = $request->getDTO();
        $country = $this->objCountryService->findByUuid($objDto->getCountry());
        $objCity= $this->objCityService->create($country , $objDto);
        return apiResponse()->success(new CityTransformer($objCity));
    }

    /**
     * Show the specified resource.
     * @param string $id
     * @return Renderable
     */
    public function getById(string $uuid): JsonResponse
    {
        $objCity = $this->objCityService->findByUuid($uuid);

        if (is_null($objCity)) {
            throw new \Exception("City Not Found.", 404);
        }

        return apiResponse()->success(new CityTransformer($objCity));
    }


    /**
     * @param string $id
     * @param UpdateCityRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(string $id , UpdateCityRequest $request): JsonResponse
    {
        $objDto = $request->getDTO();
        $country = $this->objCountryService->findByUuid($objDto->getCountry());
        $city = $this->objCityService->findByUuid($id);
        if (is_null($city)) {
            throw new \Exception("City Not Found.", 404);
        }
        $objCity = $this->objCityService->update($city , $country , $objDto);
        return apiResponse()->success(new CityTransformer($objCity));
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return Renderable
     */
    public function destroy($id):JsonResponse
    {
        $objCity= $this->objCityService->findByUuid($id);
        if (is_null($objCity)) {
            throw new \Exception("City Not Found.", 404);
        }
        $this->objCityService->delete($objCity);
        return apiResponse()->success("City has been deleted");
    }
}

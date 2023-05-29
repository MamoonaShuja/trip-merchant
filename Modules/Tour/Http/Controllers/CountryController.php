<?php

namespace Modules\Tour\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Tour\Contracts\Services\CountryContract;
use Modules\Tour\Contracts\Services\DestinationContract;
use Modules\Tour\Http\Requests\CountryRequest;
use Modules\Tour\Transformers\CountryTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CountryController extends Controller
{
    public function __construct(
        private readonly CountryContract $objCountryService,
        private readonly DestinationContract $objDestinationService,
    ) {}


    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get():JsonResponse
    {
        $countries = $this->objCountryService->get();
        return apiResponse()->success(CountryTransformer::collection($countries));
    }



    /**
     * @param CountryRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function store(CountryRequest $request): JsonResponse
    {
        $objDto = $request->getDTO();
        $objDestination = $this->objDestinationService->findByUuid($objDto->getDestination());
        $objCountry= $this->objCountryService->create($objDestination , $request->getDTO());
        return apiResponse()->success(new CountryTransformer($objCountry));
    }

    /**
     * Show the specified resource.
     * @param string $id
     * @return Renderable
     */
    public function getById(string $id): JsonResponse
    {
        $objCountry = $this->objCountryService->findByUuid($id);

        if (is_null($objCountry)) {
            throw new \Exception("Country Not Found.", 404);
        }

        return apiResponse()->success(new CountryTransformer($objCountry));
    }


    /**
     * @param string $id
     * @param CountryRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(string $id , CountryRequest $request): JsonResponse
    {

        $country = $this->objCountryService->findByUuid($id);
        $objDestination = $this->objDestinationService->findByUuid($request->getDTO()->getDestination());
        if (is_null($country)) {
            throw new \Exception("Country Not Found.", 404);
        }
        $objCountry = $this->objCountryService->update($country ,$objDestination ,  $request->getDTO());
        return apiResponse()->success(new CountryTransformer($objCountry));
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return Renderable
     */
    public function destroy($id):JsonResponse
    {
        $objCountry= $this->objCountryService->findByUuid($id);
        if (is_null($objCountry)) {
            throw new \Exception("Country Not Found.", 404);
        }
        $this->objCountryService->delete($objCountry);
        return apiResponse()->success("Country has been deleted");
    }
}

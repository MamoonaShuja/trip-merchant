<?php

namespace Modules\Tour\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Tour\Contracts\Services\DestinationContract;
use Modules\Tour\Http\Requests\CreateDestinationRequest;
use Modules\Tour\Http\Requests\UpdateDestinationRequest;
use Modules\Tour\Transformers\DestinationTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DestinationController extends Controller
{
    public function __construct(
        private readonly DestinationContract $objDestinationService
    ) {}


    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getDestinations():JsonResponse
    {
        $destinations = $this->objDestinationService->get();
        return apiResponse()->success(DestinationTransformer::collection($destinations));
    }



    /**
     * @param CreateDestinationRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function store(CreateDestinationRequest $request): JsonResponse
    {
        $objDestination= $this->objDestinationService->create($request->getDTO());
        return apiResponse()->success(new DestinationTransformer($objDestination));
    }

    /**
     * Show the specified resource.
     * @param string $id
     * @return Renderable
     */
    public function getById(string $id): JsonResponse
    {
        $objDestination = $this->objDestinationService->findByUuid($id);

        if (is_null($objDestination)) {
            throw new \Exception("Destination Not Found.", 404);
        }

        return apiResponse()->success(new DestinationTransformer($objDestination));
    }


    /**
     * @param string $id
     * @param UpdateDestinationRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(string $id , UpdateDestinationRequest $request): JsonResponse
    {

        $destination = $this->objDestinationService->findByUuid($id);
        if (is_null($destination)) {
            throw new \Exception("Destination Not Found.", 404);
        }
        $objDestination = $this->objDestinationService->update($destination , $request->getDTO());
        return apiResponse()->success(new DestinationTransformer($objDestination));
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return Renderable
     */
    public function destroy($id):JsonResponse
    {
        $objDestination= $this->objDestinationService->findByUuid($id);
        if (is_null($objDestination)) {
            throw new \Exception("Destination Not Found.", 404);
        }
        $this->objDestinationService->delete($objDestination);
        return apiResponse()->success("Destination has been deleted");
    }
}

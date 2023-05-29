<?php

namespace Modules\Tour\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Tour\Contracts\Services\CityContract;
use Modules\Tour\Contracts\Services\QuoteContract;
use Modules\Tour\Contracts\Services\TourContract;
use Modules\Tour\Http\Requests\TourQuoteRequest;
use Modules\Tour\Http\Requests\UpdateTourQuoteRequest;
use Modules\Tour\Transformers\TourQuoteTransformer;
use Modules\User\Entities\User;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TourQuoteController extends Controller
{
    public function __construct(
        private readonly QuoteContract $objTourQuoteService,
        private readonly TourContract $objTourService,
        private readonly CityContract $objCityService
    ) {}


    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get():JsonResponse
    {
        $quotes = $this->objTourQuoteService->get();
        return apiResponse()->success(TourQuoteTransformer::collection($quotes));
    }



    /**
     * @param TourQuoteRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function store(TourQuoteRequest $request): JsonResponse
    {
        /** @var User $objUser */
        $objUser = Auth::user();
        $objTour = $this->objTourService->findBySlug($request->getDTO()->getSlug());
        $objCity = $this->objCityService->findByUuid($request->getDTO()->getDepartureCity());
        $objTourQuote= $this->objTourQuoteService->create($objUser , $objTour , $objCity , $request->getDTO());
        return apiResponse()->success(new TourQuoteTransformer($objTourQuote));
    }

    /**
     * Show the specified resource.
     * @param string $id
     * @return Renderable
     */
    public function getById(string $id): JsonResponse
    {
        $objTourQuote = $this->objTourQuoteService->findByUuid($id);

        if (is_null($objTourQuote)) {
            throw new \Exception("TourQuote Not Found.", 404);
        }

        return apiResponse()->success(new TourQuoteTransformer($objTourQuote));
    }


    /**
     * @param string $id
     * @param UpdateTourQuoteRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function update(string $id , UpdateTourQuoteRequest $request): JsonResponse
    {
        $objTourQuote = $this->objTourQuoteService->findByUuid($id);
        if (is_null($objTourQuote)) {
            throw new \Exception("TourQuote Not Found.", 404);
        }
        $objTourQuote = $this->objTourQuoteService->update($objTourQuote , $request->getDTO());
        return apiResponse()->success(new TourQuoteTransformer($objTourQuote));
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return Renderable
     */
    public function destroy($id):JsonResponse
    {
        $objTourQuote= $this->objTourQuoteService->findByUuid($id);
        if (is_null($objTourQuote)) {
            throw new \Exception("TourQuote Not Found.", 404);
        }
        $this->objTourQuoteService->delete($objTourQuote);
        return apiResponse()->success("TourQuote has been deleted");
    }
}

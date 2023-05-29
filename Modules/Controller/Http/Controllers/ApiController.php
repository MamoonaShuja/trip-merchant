<?php

namespace Modules\SupplierApi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Modules\SupplierApi\Contracts\Services\ApiSupplierContract;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ApiController extends Controller
{
    public function __construct(private readonly ApiSupplierContract $objApiSupplierService){

    }
    public function getApis():JsonResponse{

    }

    /**
     * @param string $strApiName
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getSingleSupplier(string $strApiName):JsonResponse{
        $objSupplierApi = $this->objApiSupplierService->getByName($strApiName);
        $this->objApiSupplierService->createIds($objSupplierApi);
        return apiResponse()->success("Record Saved Successfully");
    }

    /**
     * @param string $strApiName
     * @return JsonResponse
     */
    public function getAllTours(string $strApiName):JsonResponse{
        $objSupplierApi = $this->objApiSupplierService->getByName($strApiName);
        $arrTours = $this->objApiSupplierService->getSingleSupplierAllTours($objSupplierApi);
        dd($arrTours);
    }
}

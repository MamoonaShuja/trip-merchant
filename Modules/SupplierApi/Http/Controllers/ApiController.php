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

    /**
     * @param string $strApiName
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getSingleSupplier(string $strApiName):void{
        $objSupplierApi = $this->objApiSupplierService->getByName($strApiName);
        $objSupplierApi = $this->objApiSupplierService->createIds($objSupplierApi);
        $this->objApiSupplierService->getSingleSupplierAllTours($objSupplierApi , null);
    }

    /**
     * @param string $strApiName
     * @return JsonResponse
     */
    public function getAllTours(string $strApiName , string $id = null):JsonResponse{
        $objSupplierApi = $this->objApiSupplierService->getByName($strApiName);
        $arrTours = $this->objApiSupplierService->getSingleSupplierAllTours($objSupplierApi , $id);
        dd($arrTours);
    }
}

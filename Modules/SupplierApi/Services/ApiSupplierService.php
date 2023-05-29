<?php
namespace Modules\SupplierApi\Services;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Queue;
use Modules\SupplierApi\Contracts\Repositories\ApiSupplierRepositoryContract;
use Modules\SupplierApi\Contracts\Services\ApiSupplierContract;
use Modules\SupplierApi\Contracts\Services\ApiTourIdContract;
use Modules\SupplierApi\Contracts\Services\SingleRecordContract;
use Modules\SupplierApi\Entities\ApiSupplier;
use Modules\SupplierApi\Enum\SupplierResponse;
use Modules\SupplierApi\Jobs\FetchToursJob;


class ApiSupplierService extends FetchRecordService implements ApiSupplierContract
{
    public function __construct(
        private readonly ApiSupplierRepositoryContract $objApiSupplierRepository,
        private readonly ApiTourIdContract $objTourIdService,

    )
    {
    }

    public function get():Collection
    {
        return $this->objApiSupplierRepository->get();
    }

    public function getByName(string $strApiName):ApiSupplier
    {
        return $this->objApiSupplierRepository->getByName($strApiName);
    }

    public function createIds(ApiSupplier $objApiSupplier):Collection
    {

        /** @var SingleRecordContract $class */
        $class = new $objApiSupplier->class_name();
        $uniqueTourKeys = $class->getUniqueIds(
            $objApiSupplier ,
            $objApiSupplier->return_type == SupplierResponse::JSON->value ?
                $this->getDecodedJson($objApiSupplier, $objApiSupplier->main_url)
                :
                $this->getDecodedXml($objApiSupplier, $objApiSupplier->main_url)
        );
        $objUniqueTourKeys = $this->objTourIdService->create($uniqueTourKeys);
        return $this->objApiSupplierRepository->saveUniqueIds($objApiSupplier , $objUniqueTourKeys);
    }


    /**
     * @param ApiSupplier $objApiSupplier
     * @return array
     */
    public function getSingleSupplierAllTours(ApiSupplier $objApiSupplier , string|null $strTourUniqueId):void{
        $uniqueTourKeys = $objApiSupplier->nonFetchedTourIds()
            ->when($strTourUniqueId , function ($query) use ($strTourUniqueId){
              return $query->whereUniqueKey($strTourUniqueId);
            })->pluck('unique_key');
        foreach ($uniqueTourKeys as $uniqueTourKey){
//            FetchToursJob::dispatch($this->objTourIdService , $objApiSupplier , $uniqueTourKey);

            $strSingleRecordUrl = sprintf($objApiSupplier->single_record_url , $uniqueTourKey);
            $objApiTourId = $this->objTourIdService->getTourIdByUniqueKey($uniqueTourKey);
            $objApiSupplier->return_type == SupplierResponse::JSON->value ?
                $this->parseSingleRecord(
                    $this->getDecodedJson($objApiSupplier, $strSingleRecordUrl) ,
                    $objApiSupplier->class_name , $objApiTourId)
                :
                $this->parseSingleRecord(
                    $this->getDecodedXml($objApiSupplier, $strSingleRecordUrl) ,
                    $objApiSupplier->class_name , $objApiTourId);
        }
    }
}

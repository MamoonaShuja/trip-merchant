<?php
namespace Modules\SupplierApi\Repositories;


use Modules\SupplierApi\Contracts\Repositories\ApiTourIdRepositoryContract;
use Modules\SupplierApi\Entities\ApiTourId;

class ApiTourIdRepository implements ApiTourIdRepositoryContract
{


    public function __construct(private readonly ApiTourId $model){

    }
    public function create(string $strUniqueId):ApiTourId
    {
        $objApiTourId = new ApiTourId([
            'unique_key' => $strUniqueId,
            'fetched' => 0,
        ]);
        return $objApiTourId;
    }

    public function getTourIdByUniqueKey(string $strUniqueKey): ApiTourId
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereUniqueKey($strUniqueKey)->first();
    }

    /**
     * @inheritDoc
     */
    public function changeFetchStatus(ApiTourId $objApiTourId, bool $boolFetchedStatus): ApiTourId
    {
        if($objApiTourId->fetched != $boolFetchedStatus && is_bool($boolFetchedStatus)){
            $objApiTourId->fetched = $boolFetchedStatus;
            if($boolFetchedStatus === 1){
                $objApiTourId->last_scrapped_at = now();
            }
        }
        $objApiTourId->save();
        return $objApiTourId;
    }
}


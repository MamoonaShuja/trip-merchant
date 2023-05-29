<?php
namespace Modules\SupplierApi\Contracts\Services;


use Modules\SupplierApi\Entities\ApiTourId;

interface ApiTourIdContract
{
    public function create(array $uniqueTourKeys):array;

    /**
     * @param string $uniqueTourKey
     * @return ApiTourId
     */
    public function getTourIdByUniqueKey(string $uniqueTourKey):ApiTourId;

    /**
     * @param ApiTourId $objApiTourId
     * @return ApiTourId
     */
    public function fetched(ApiTourId $objApiTourId , bool $boolFetchedStatus):ApiTourId;
}

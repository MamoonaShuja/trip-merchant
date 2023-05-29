<?php
namespace Modules\SupplierApi\Contracts\Repositories;


use Modules\SupplierApi\Entities\ApiTourId;

interface ApiTourIdRepositoryContract
{
    /**
     * @param string $strUniqueId
     * @return mixed
     */
    public function create(string $strUniqueId);

    /**
     * @param string $strUniqueKey
     * @return ApiTourId
     */
    public function getTourIdByUniqueKey(string $strUniqueKey):ApiTourId;

    /**
     * @param ApiTourId $objApiTourId
     * @param bool $boolFetchedStatus
     * @return ApiTourId
     */
    public function changeFetchStatus(ApiTourId $objApiTourId , bool $boolFetchedStatus):ApiTourId;

}

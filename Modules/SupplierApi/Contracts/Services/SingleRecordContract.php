<?php
namespace Modules\SupplierApi\Contracts\Services;

use Illuminate\Contracts\Container\Container;
use Modules\SupplierApi\Entities\ApiSupplier;
use Modules\SupplierApi\Entities\ApiTourId;

interface SingleRecordContract
{

    /**
     * @param array $allRecordData
     * @return object
     */
    public function parse(array $allRecordData , Container $container , ApiTourId $objApiTourId):void;

    /**
     * @param ApiSupplier $objApiSupplier
     * @param array $allRecordData
     * @return array
     */
    public function getUniqueIds(ApiSupplier $objApiSupplier, array $allRecordData):array;
}

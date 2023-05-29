<?php
namespace Modules\SupplierApi\Contracts\Services;

use Modules\SupplierApi\Entities\ApiSupplier;
use Modules\SupplierApi\Entities\ApiTourId;

interface FetchRecordContract
{
    /**
     * @param ApiSupplier $objApiSupplier
     * @param string $strUrl
     * @return array
     */
    public function getDecodedJson(ApiSupplier $objApiSupplier , string $strUrl):array;

    /**
     * @param ApiSupplier $objApiSupplier
     * @param string $strUrl
     * @return array
     */
    public function getDecodedXml(ApiSupplier $objApiSupplier , string $strUrl):array;

    /**
     * @param array $allRecordData
     * @param string $strClassName
     * @return object
     */
    public function parseSingleRecord(array $allRecordData , string $strClassName , ApiTourId $objApiTourId):void;
}

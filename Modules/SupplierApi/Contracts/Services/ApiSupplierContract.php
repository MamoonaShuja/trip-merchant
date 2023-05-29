<?php
namespace Modules\SupplierApi\Contracts\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\SupplierApi\Entities\ApiSupplier;

interface ApiSupplierContract
{
    /**
     * @return mixed
     */
    public function get();

    /**
     * @param string $strApiName
     * @return mixed
     */
    public function getByName(string $strApiName);

    /**
     * @param string $strApiName
     * @return mixed
     */
    public function createIds(ApiSupplier $objApiSupplier):Collection;

    /**
     * @param ApiSupplier $objApiSupplier
     * @return array
     */
    public function getSingleSupplierAllTours(ApiSupplier $objApiSupplier , string|null $strTourUniqueId):void;
}

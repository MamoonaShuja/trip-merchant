<?php
namespace Modules\SupplierApi\Contracts\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Modules\SupplierApi\Entities\ApiSupplier;

interface ApiSupplierRepositoryContract
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get():Collection;

    /**
     * @param ApiSupplier $objApiSupplier
     * @param array $objApiTourIds
     * @return Collection
     */
    public function saveUniqueIds(ApiSupplier $objApiSupplier , array $objApiTourIds):Collection;

    /**
     * @param string $strApiName
     * @return ApiSupplier
     */
    public function getByName(string $strApiName):ApiSupplier;
}

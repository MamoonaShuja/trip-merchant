<?php
namespace Modules\SupplierApi\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Modules\SupplierApi\Contracts\Repositories\ApiSupplierRepositoryContract;
use Modules\SupplierApi\Entities\ApiSupplier;

class ApiSupplierRepository implements ApiSupplierRepositoryContract
{
    public function __construct(private readonly ApiSupplier $model) {}

    /**
     * @return Collection
     */
    public function get():Collection{
        $objQuery = $this->model->newQuery();
        return $objQuery->get();
    }

    /**
     * @param ApiSupplier $objApiSupplier
     * @param array $objApiTourIds
     * @return Collection|mixed
     */
    public function saveUniqueIds(ApiSupplier $objApiSupplier , array $objApiTourIds):Collection{
        $objApiSupplier->tourIds()->saveMany($objApiTourIds);
        $objApiSupplier->last_scrapped_at = now();
        $objApiSupplier->save();
        return  $objApiSupplier->tourIds()->get();
    }

    /**
     * @param string $strApiName
     * @return ApiSupplier
     */
    public function getByName(string $strApiName):ApiSupplier{
        $objQuery = $this->model->newQuery();
        return $objQuery->where('name', 'like', '%'.$strApiName.'%')->first();
    }
}

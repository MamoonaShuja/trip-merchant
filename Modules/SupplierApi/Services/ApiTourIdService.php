<?php
namespace Modules\SupplierApi\Services;


use Modules\SupplierApi\Contracts\Repositories\ApiTourIdRepositoryContract;
use Modules\SupplierApi\Contracts\Services\ApiTourIdContract;
use Modules\SupplierApi\Entities\ApiTourId;

class ApiTourIdService implements ApiTourIdContract
{
    public function __construct(private readonly ApiTourIdRepositoryContract $objApiTourIdRepository)
    {
    }

    public function create(array $uniqueTourKeys):array{
        $objUniqueTourIds = [];
        foreach ($uniqueTourKeys as $uniqueTourKey) {
            $objUniqueTourIds[] = $this->objApiTourIdRepository->create($uniqueTourKey);
        }
        return $objUniqueTourIds;
    }

    /**
     * @param string $uniqueTourKey
     * @return ApiTourId
     */
    public function getTourIdByUniqueKey(string $uniqueTourKey): ApiTourId
    {
        return $this->objApiTourIdRepository->getTourIdByUniqueKey($uniqueTourKey);
    }

    /**
     * @inheritDoc
     */
    public function fetched(ApiTourId $objApiTourId , bool $boolFetchedStatus): ApiTourId
    {
        return $this->objApiTourIdRepository->changeFetchStatus($objApiTourId , $boolFetchedStatus);
    }
}

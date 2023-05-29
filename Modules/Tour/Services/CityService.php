<?php

namespace Modules\Tour\Services;

use Illuminate\Support\Collection;
use Modules\Tour\Contracts\Repositories\CityRepositoryContract;
use Modules\Tour\Contracts\Services\CityContract;
use Modules\Tour\Entities\City;
use Modules\Tour\DataTransfer\Requests\CityDTO;
use Modules\Tour\Entities\Country;

class CityService implements CityContract
{
    public function __construct(
        //Repositories
        private readonly CityRepositoryContract $objCityRepository,
    ) {}

    /**
     * @param CityDTO $createCityDTO
     * @return City
     */
    public function create(Country $objCountry , CityDTO $createCityDTO): City
    {
        return $this->objCityRepository->create(
            $objCountry,
            $createCityDTO->getName(),
        );

    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->objCityRepository->getCities();
    }

    /**
     * @param string $id
     * @return City|null
     */
    public function findById(string $id): ?City
    {
        return $this->objCityRepository->findById($id);
    }

    public function findByUuid(string $id): ?City
    {
        return $this->objCityRepository->findByUuid($id);
    }

    public function delete(City $city): ?bool
    {
        return $this->objCityRepository->deleteCity($city);
    }

    /**
     * @param City $objCity
     * @param CityDTO $updateCityDTO
     * @return City
     */
    public function update(City $objCity, Country $objCountry , CityDTO $updateCityDTO): City
    {
        return $this->objCityRepository->updateCity(
            $objCity,
            $objCountry,
            $updateCityDTO->getName(),
        );
    }

}

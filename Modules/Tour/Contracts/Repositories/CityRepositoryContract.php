<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Support\Collection;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Country;

interface CityRepositoryContract
{

    /**
     * @param string $name
     * @return mixed
     */
    public function create(
        Country $objCountry,
        string   $name,
    );

    /**
     * @return Collection|null
     */
    public function getCities(): ?Collection;

    /**
     * @param string $id
     * @return City|null
     */
    public function findById(string $id): ?City;

    /**
     * @param string $id
     * @return City|null
     */
    public function findByUuid(string $id): City|null;

    /**
     * @param City $city
     * @return bool
     */
    public function deleteCity(City $city): bool;

    /**
     * @param City $objCity
     * @param string|null $strName
     * @return City
     */
    public function updateCity(
        City $objCity,
        Country $objCountry,
        ?string $strName = null,
    ): City;

    /**
     * @param string $strName
     * @return City|null
     */
    public function findByName(string $strName): City|null;
}

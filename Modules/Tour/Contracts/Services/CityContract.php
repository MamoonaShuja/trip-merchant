<?php

namespace Modules\Tour\Contracts\Services;

use Illuminate\Support\Collection;
use Modules\Tour\DataTransfer\Requests\CityDTO;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Country;

interface CityContract
{
    /**
     * @param CityDTO $cityCreateDTO
     * @return City
     */
    public function create(Country $objCountry , CityDTO $cityCreateDTO): City;

    /**
     * @return Collection
     */
    public function get() :Collection;

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
     * @return bool|null
     */
    public function delete(City $city): ?bool;


    /**
     * @param City $objCity
     * @param CityDTO $updateCityDTO
     * @return City
     */
    public function update(City $objCity , Country $objCountry , CityDTO $updateCityDTO): City;

}

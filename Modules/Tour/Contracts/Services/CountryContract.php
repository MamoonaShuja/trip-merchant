<?php

namespace Modules\Tour\Contracts\Services;

use Illuminate\Support\Collection;
use Modules\Tour\DataTransfer\Requests\CountryDTO;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Entities\Country;

interface CountryContract
{
    /**
     * @param CountryDTO $countryCreateDTO
     * @return Country
     */
    public function create(Destination $objDestination , CountryDTO $countryDTO): Country;

    /**
     * @return Collection
     */
    public function get() :Collection;

    /**
     * @param string $id
     * @return Country|null
     */
    public function findById(string $id): Country|null;

    /**
     * @param string $id
     * @return Country|null
     */
    public function findByUuid(string $id): Country|null;

    /**
     * @param Country $country
     * @return bool|null
     */
    public function delete(Country $country): ?bool;


    /**
     * @param Country $objCountry
     * @param Destination $objDestination
     * @param CountryDTO $updateCountryDTO
     * @return Country
     */
    public function update(Country $objCountry , Destination $objDestination , CountryDTO $countryDTO): Country;

}

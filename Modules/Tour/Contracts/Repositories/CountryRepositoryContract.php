<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Support\Collection;
use Modules\Tour\Entities\Country;
use Modules\Tour\Entities\Destination;

interface CountryRepositoryContract
{

    /**
     * @param string $name
     * @return mixed
     */
    public function create(
        Destination $objDestination,
        string   $name,
    ):Country;

    /**
     * @return Collection|null
     */
    public function get(): ?Collection;

    /**
     * @param string $id
     * @return Country|null
     */
    public function findById(string $id): ?Country;

    /**
     * @param string $id
     * @return Country|null
     */
    public function findByUuid(string $id): Country|null;

    /**
     * @param Country $country
     * @return bool
     */
    public function delete(Country $country): bool;

    /**
     * @param Country $objCountry
     * @param string|null $strName
     * @return Country
     */
    public function update(
        Country $objCountry,
        Destination $objDestination,
        string|null $strName = null,
    ): Country;

    /**
     * @param string $strName
     * @return Country|null
     */
    public function findByName(string $strName): Country|null;
}

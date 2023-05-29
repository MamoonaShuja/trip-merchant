<?php

namespace Modules\Tour\Services;

use Illuminate\Support\Collection;
use Modules\Tour\Contracts\Repositories\CountryRepositoryContract;
use Modules\Tour\Contracts\Services\CountryContract;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Entities\Country;
use Modules\Tour\DataTransfer\Requests\CountryDTO;

class CountryService implements CountryContract
{
    public function __construct(
        //Repositories
        private readonly CountryRepositoryContract $objCountryRepository,
    ) {}

    /**
     * @param CountryDTO $createCountryDTO
     * @return Country
     */
    public function create(Destination $objDestination , CountryDTO $createCountryDTO): Country
    {
        return $this->objCountryRepository->create(
            $objDestination,
            $createCountryDTO->getName(),
        );

    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->objCountryRepository->get();
    }

    /**
     * @param string $id
     * @return Country|null
     */
    public function findById(string $id): ?Country
    {
        return $this->objCountryRepository->findById($id);
    }

    public function findByUuid(string $id): ?Country
    {
        return $this->objCountryRepository->findByUuid($id);
    }

    public function delete(Country $city): ?bool
    {
        return $this->objCountryRepository->delete($city);
    }

    /**
     * @param Country $objCountry
     * @param CountryDTO $updateCountryDTO
     * @return Country
     */
    public function update(Country $objCountry, Destination $objDestination ,  CountryDTO $updateCountryDTO): Country
    {
        return $this->objCountryRepository->update(
            $objCountry,
            $objDestination,
            $updateCountryDTO->getName(),
        );
    }

}

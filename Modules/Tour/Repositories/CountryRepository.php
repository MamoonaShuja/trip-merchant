<?php

namespace Modules\Tour\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\CountryRepositoryContract;
use Modules\Tour\Entities\Country;
use Modules\Tour\Entities\Destination;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CountryRepository implements CountryRepositoryContract
{
    public function __construct(private readonly Country $model) {}

    /**
     * @param Destination $objDestination
     * @param string $name
     * @return Country
     */
    public function create(Destination $objDestination , string $name): Country
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->create([
            'name' => $name,
            'country_uuid' => Str::uuid(),
            'destination_id' => $objDestination->id
        ]);
    }


    /**
     * @return Collection|null
     */
    public function get(): ?Collection
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->latest()->get();
    }

    /**
     * @param string $id
     * @return Country|null
     */
    public function findById(string $id): Country|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->find($id);
    }

    public function findByUuid(string $id): Country|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereCountryUuid($id)->first();
    }

    /**
     * @param Country $tourCountry
     * @return bool
     */
    public function delete(Country $tourCountry): bool
    {
        return $tourCountry->delete();
    }

    /**
     * @param Country $objCountry
     * @param string|null $strName
     * @param string|null $strContent
     * @param UploadedFile|null $uploadedFile
     * @return Country
     */
    public function update(Country $objCountry, Destination $objDestination , ?string $strName = null): Country
    {
        if (is_string($strName) && $objCountry->name !== $strName)
            $objCountry->name = $strName;
        if (is_string($objDestination->id) && $objCountry->destination_id !== $objDestination->id)
            $objCountry->destination_id = $objDestination->id;
        $objCountry->update();
        return $objCountry;
    }

    /**
     * @param string $strName
     * @return Country|null
     */
    public function findByName(string $strName): Country|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereName($strName)->first();
    }
}

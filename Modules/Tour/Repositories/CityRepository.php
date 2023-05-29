<?php

namespace Modules\Tour\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\CityRepositoryContract;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Country;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CityRepository implements CityRepositoryContract
{
    public function __construct(private readonly City $model) {}

    /**
     * @param string $name
     * @param string $content
     * @param UploadedFile|null $file
     * @return City
     */
    public function create(Country $objCountry,string $name): City
    {
        $objQuery = $this->model->newQuery();
        $objCity = $objQuery->create([
            'name' => $name,
            'city_uuid' => Str::uuid(),
            "country_id" => $objCountry->id
        ]);
        return $objCity;
    }


    /**
     * @return Collection|null
     */
    public function getCities(): ?Collection
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->latest()->with(['country'])->get();
    }

    /**
     * @param string $id
     * @return City|null
     */
    public function findById(string $id): City|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->find($id);
    }

    public function findByUuid(string $id): City|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereCityUuid($id)->first();
    }

    /**
     * @param City $city
     * @return bool
     */
    public function deleteCity(City $city): bool
    {
        return $city->delete();
    }

    /**
     * @param City $objCity
     * @param string|null $strName
     * @param string|null $strContent
     * @param UploadedFile|null $uploadedFile
     * @return City
     */
    public function updateCity(City $objCity, Country $objCountry, ?string $strName = null): City
    {
        if (is_string($strName) && $objCity->name !== $strName)
            $objCity->name = $strName;
        if (is_string($objCountry->id) && $objCity->country_id !== $objCountry->id)
            $objCity->country_id = $objCountry->id;
        $objCity->update();
        return $objCity;
    }

    /**
     * @param string $strName
     * @return City|null
     */
    public function findByName(string $strName): City|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereName($strName)->first();
    }
}

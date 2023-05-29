<?php
namespace Modules\SupplierApi\Services;


use Modules\SupplierApi\Contracts\Services\ValidatingForeignKeyContract;
use Modules\Tour\Contracts\Repositories\CityRepositoryContract;
use Modules\Tour\Contracts\Repositories\CountryRepositoryContract;
use Modules\Tour\Contracts\Repositories\DestinationRepositoryContract;
use Modules\Tour\Contracts\Repositories\TravelStyleRepositoryContract;
use Modules\Tour\Entities\TravelStyle;

class ValidatingForeignKeyService implements ValidatingForeignKeyContract
{
    public function __construct(
        private readonly TravelStyleRepositoryContract $objTravelStyleRepository,
        private readonly DestinationRepositoryContract $objDestinationRepository,
        private readonly CountryRepositoryContract $objCountryRepository,
        private readonly CityRepositoryContract $objCityRepository,
    ){

    }

    public function validateDestination(string $strDestination): string
    {
        $objDestination = $this->objDestinationRepository->findByName($strDestination);
        if(is_null($objDestination))
            $objDestination = $this->objDestinationRepository->create(
                $strDestination,
                ""
            );
        return $objDestination->id;
    }

    public function validateCountry(string $strDestination, string $strCountry): string
    {
        $objCountry = $this->objCountryRepository->findByName($strCountry);
        $objDestination = $this->objDestinationRepository->findById($strDestination);
        if(is_null($objCountry))
            $objCountry = $this->objCountryRepository->create(
                $objDestination,
                $strCountry,
            );
        return $objCountry->id;
    }

    public function validateTravelStyle(string $strTravelStyle): TravelStyle
    {
        $objTravelStyle = $this->objTravelStyleRepository->findByName($strTravelStyle);
        if(is_null($objTravelStyle))
            $objTravelStyle = $this->objTravelStyleRepository->create(
                $strTravelStyle,
                "",
                0
            );
        return $objTravelStyle;
    }

    public function validateCity(string $strCountry, string $strCity): string
    {
        $objCity = $this->objCityRepository->findByName($strCity);
        $objCountry = $this->objCountryRepository->findById($strCountry);
        if(is_null($objCity))
            $objCity = $this->objCityRepository->create(
                $objCountry,
                $strCity,
            );
        return $objCity->id;
    }

}

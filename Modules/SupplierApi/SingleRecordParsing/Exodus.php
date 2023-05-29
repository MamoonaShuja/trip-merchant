<?php

namespace Modules\SupplierApi\SingleRecordParsing;


use Illuminate\Contracts\Container\Container;
use Modules\SupplierApi\Contracts\Repositories\ApiSupplierRepositoryContract;
use Modules\SupplierApi\Contracts\Services\ApiTourIdContract;
use Modules\SupplierApi\Contracts\Services\SingleRecordContract;
use Modules\SupplierApi\Contracts\Services\ValidatingForeignKeyContract;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\SupplierApi\Entities\ApiSupplier;
use Modules\SupplierApi\Entities\ApiTourId;
use Modules\SupplierApi\Services\ApiTourService;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\User\Contracts\Repositories\UserRepositoryContract;

class Exodus extends ApiTourService implements SingleRecordContract
{
    private ValidatingForeignKeyContract $objValidatingForeignKeyService;
    private UserRepositoryContract $objUserRepository;
    private ApiTourIdContract $objTourIdService;
    private ApiSupplierRepositoryContract $objApiSupplierRepository;
    /**
     * @param ApiSupplier $objApiSupplier
     * @param array $allRecordData
     * @return array
     */
    public function initializeServiceContainers(Container $container):void{
        /** @var ValidatingForeignKeyContract $objValidatingForeignKeyServiceService */
        $this->objValidatingForeignKeyService = $container->make(ValidatingForeignKeyContract::class);
        /** @var UserRepositoryContract $objUserRepository */
        $this->objUserRepository = $container->make(UserRepositoryContract::class);
        /** @var TourRepositoryContract $objTourRepository */
        $this->objTourRepository = $container->make(TourRepositoryContract::class);
        /** @var ApiSupplierRepositoryContract $objApiSupplierRepository */
        $this->objApiSupplierRepository = $container->make(ApiSupplierRepositoryContract::class);
        /** @var ApiTourIdContract $objApiSupplierRepository */
        $this->objTourIdService = $container->make(ApiTourIdContract::class);
    }

    /**
     * @param ApiSupplier $objApiSupplier
     * @param array $allRecordData
     * @return array
     */
    public function getUniqueIds(ApiSupplier $objApiSupplier, array $allRecordData): array{
        $previousIds = $objApiSupplier->tourIds()->pluck('unique_key')->toArray();
        $allIds = array_unique(array_values($allRecordData)[0]);
        return array_diff($allIds, $previousIds);
    }

    /**
     * @param array $allRecordData
     * @return object
     */
    public function parse(array $allRecordData , Container $container , ApiTourId $objApiTourId): void
    {
        $this->initializeServiceContainers($container);
        dd($allRecordData['holidaytype']);
        try {
            //For Pricing
            $arrTourDates = $allRecordData['TourDates'];
            //Travel Style

            $objTravelStyle = $this->objValidatingForeignKeyService->validateTravelStyle("Group Departure");
            //Destination
            $arrDestinationIds = $this->getDestinations($allRecordData['Destinations']);

            //Country
            $arrCountryIds = $this->getCountries($arrDestinationIds);
            //ArrivalCity
            $arrArrivalCities[] = $this->objValidatingForeignKeyService->validateCity($arrCountryIds[0], $allRecordData['start_destination']);

            //DepartureCity
            $arrDepartureCities[] = $this->objValidatingForeignKeyService->validateCity($arrCountryIds[0], $allRecordData['end_destination']);

            //SupplierApi
            $objSupplierApi = $this->objApiSupplierRepository->getByName("Exodus Travels (Adventure and Active Travel)");

            $objApiTourDTO = new ApiTourDTO(
                $allRecordData['name'], //title
                $this->findPrice($arrTourDates), //members_rate
                null,
                null,
                $allRecordData['NumberOfDays'],
                $allRecordData['NumberOfDays'],
                null,
                $allRecordData['synopsis']." ".$allRecordData['editorial'], //overView
                $allRecordData['highlight'], //highlight
                $allRecordData['included'] ,
                null,
                $allRecordData['not_included'],
                $allRecordData['NumberOfMeals'],
                $allRecordData['grade'],
                null,
                null,
                null,
                1,
                $arrArrivalCities,
                $arrDepartureCities,
                $arrCountryIds,
                $objTravelStyle->id,
                $arrDestinationIds,
                $this->getItineraries($allRecordData['Itinerary']),
                $this->getTourDepartureDates($allRecordData['TourDates']),
                null,
                $this->getTourLocation($allRecordData['mapfile']),
                null,
                null,
                null,
                null,
                $this->getSliderOrGallery($allRecordData['images']['image']), //Gallery
                $this->getSliderOrGallery($allRecordData['images']['image']),
                null,
                null,
                $objSupplierApi->id,
                $objApiTourId->id,
                $this->getImage($allRecordData['images']['image']),
                $this->objUserRepository->getAdmin()
            );
            $this->saveTour($objSupplierApi, $objApiTourDTO, $container);
            $this->objTourIdService->fetched($this->objTourIdService->getTourIdByUniqueKey($allRecordData['TourId']) , 1);
        }catch (\Throwable $ex){
        }
    }

    /**
     * @param array $arrImages
     * @param array $arrItineraries
     * @return array
     */
    public function getTourLocation(string $mapFile): array{
        $objLocations = [];
        $objLocationImage = [];
        $objLocationImage['map_image'] = $mapFile;
        $objLocationImage['lat'] = $mapFile;
        $objLocationImage['long'] = $mapFile;
        array_push($objLocations , $objLocationImage);
        return $objLocations;
    }

    /**
     * @param array $arrImages
     * @return array
     */
    function getSliderOrGallery(array $arrImages): array{
        $objImages = [];
        foreach ($arrImages as $arrImage) {
            $url= $arrImage['file'];
            array_push($objImages , $url);
        }
        return $objImages;
    }
    /**
     * @param array $arrImages
     * @return array
     */
    function getImage(array $arrImages): string{
        $url = "";
        foreach ($arrImages as $arrImage) {
            $url = $arrImage['Url'];
            break;
        }
        return $url;
    }

    /**
     * @param array $tourDates
     * @return float
     */
    function findPrice(array $tourDates): float {
        $smallestPrice = PHP_FLOAT_MAX;
        foreach ($tourDates as $tourDate) {
            foreach ($tourDate['RoomPricing'] as $roomPricing) {
                $price = $roomPricing['PriceAdultLandPerPerson'] + $roomPricing['PriceAdultRequiredSupplementPerPerson'];
                if ($price < $smallestPrice) {
                    $smallestPrice = $price;
                }
            }
        }
        return $smallestPrice;
    }

}



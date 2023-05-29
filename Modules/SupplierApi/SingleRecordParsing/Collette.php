<?php

namespace Modules\SupplierApi\SingleRecordParsing;


use Http\Client\Exception;
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

class Collette extends ApiTourService implements SingleRecordContract
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
        $allIds = array_unique(array_column($allRecordData , $objApiSupplier->unique_id_key));
        return array_diff($allIds, $previousIds);
    }

    /**
     * @param array $allRecordData
     * @return object
     */
    public function parse(array $allRecordData , Container $container , ApiTourId $objApiTourId): void
    {
        $this->initializeServiceContainers($container);
       try {
           //For Pricing
           $arrTourDates = $allRecordData['TourDates'];
           //For HighLights
           $arrExperiences = $allRecordData['Experiences'] ?? [];
           $arrCulinaries = $allRecordData['Culinaries'] ?? [];
           $arrMustSees = $allRecordData['MustSees'] ?? [];
           //Travel Style

           if($objApiTourId->unique_key == 211 || $objApiTourId->unique_key == 705 || $objApiTourId->unique_key == 209 || $objApiTourId->unique_key == 569)
              $objTravelStyle = $this->objValidatingForeignKeyService->validateTravelStyle("River Cruises");
           else
               $objTravelStyle = $this->objValidatingForeignKeyService->validateTravelStyle("Guided Tours");
           //Destination
           $arrDestinationIds = $this->getDestinations($allRecordData['Destinations']);

           //Country
           $arrCountryIds = $this->getCountries($arrDestinationIds);
           //ArrivalCity
           $arrArrivalCities[] = $this->objValidatingForeignKeyService->validateCity($arrCountryIds[0], $allRecordData['Air']['InboundAirportName']);

           //DepartureCity
           $arrDepartureCities[] = $this->objValidatingForeignKeyService->validateCity($arrCountryIds[0], $allRecordData['Air']['OutboundAirportName']);

           //SupplierApi
           $objSupplierApi = $this->objApiSupplierRepository->getByName("Collette (Guided Tour)");

           $objApiTourDTO = new ApiTourDTO(
               $allRecordData['TourName'], //title
               $this->findSmallestPrice($arrTourDates), //members_rate
               null,
               null,
               $allRecordData['NumberOfDays'],
               $allRecordData['NumberOfDays'],
               null,
               $allRecordData['TourDescription'],
               $this->getHighlights([$arrExperiences, $arrMustSees, $arrCulinaries]),
               null,
               null,
               null,
               $allRecordData['NumberOfMeals'],
               $this->getActivityLevel($allRecordData['ActivityLevel']),
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
               $this->getTourLocation($allRecordData['Images'], $allRecordData['Itinerary']),
               null,
               null,
               null,
               null,
               $this->getSliderOrGallery($allRecordData['Images']), //Gallery
               $this->getSliderOrGallery($allRecordData['Images']),
               null,
               null,
               $objSupplierApi->id,
               $objApiTourId->id,
               $this->getImage($allRecordData['Images']),
               $this->objUserRepository->getAdmin()
           );
           $this->saveTour($objSupplierApi, $objApiTourDTO, $container);
           $this->objTourIdService->fetched($this->objTourIdService->getTourIdByUniqueKey($allRecordData['TourId']) , 1);
       }catch (\Throwable $ex){
       }
    }


    /**
     * @param array $tourDates
     * @return float
     */
    function findSmallestPrice(array $tourDates): float {
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

    /**
     * @param array $data
     * @return string
     */
    private function getHighlights(array $data): string
    {
        foreach ($data as $category) {
            foreach ($category as $item) {
                $highlights[] = $item['Description'];
            }
        }
        $strHighlights = '<ul><li>' . implode('</li><li>', $highlights) . '</li></ul>';
        return $strHighlights;
    }

    /**
     * @param $strActivityLevel
     * @return string
     */
    function getActivityLevel($strActivityLevel):string {
        return match($strActivityLevel) {
            "1" => "You’re a leisurely traveler. You like to discover the energy of a new place, but typically take it easy. You can handle at least one flight of stairs, board a coach, and walk for 15-30 minutes at a time with little difficulty.",
            "2" => "You like a balanced approach to travel. You feel confident walking at least 30-45 minutes at a time over a variety of terrains – from cobblestones streets to easy straightaways to a couple hills or flights of stairs. You’re comfortable walking a few city blocks at a time, but need some time to unwind and relax.",
            "3" => "You’re an on-the-go traveler. You don’t want to miss a thing, so walking and standing for longer periods of time (1-2 hours) isn’t a big deal. You can navigate hills and uneven ground, climb into various modes of transportation (tuk-tuk, cable car, zodiac, etc.), and could possibly anticipate changes in elevation. You can expect some longer days balanced with free time to recharge or set out on your own adventure.",
            "4" => "You’re ready to seize the day, whatever it may bring. You lead an active life at home (walking, biking, and hiking are things you may enjoy) and few thousand steps a day isn’t out of the norm. You can handle longer walking tours (more than 90 minutes), traversing dusty or uneven terrain, standing for periods of time, varying altitudes and temperatures, and don’t mind being on the go with some early starts, late-night experiences, and full days. Unfortunately, this level is not appropriate for individuals who use wheelchairs or walkers.",
            default => ""
        };
    }

    /**
     * @param array $arrItineraries
     * @return string
     */
    public function getDestinations(array $allDestinations):array{
        $arrDestinationIds = [];
        foreach ($allDestinations as $destination) {
            $arrDestinationIds[] = $this->objValidatingForeignKeyService->validateDestination($destination['Country']);
        }
        return $arrDestinationIds;
    }

    public function getCountries(array $arrDestinations):array{
        $arrCountryIds = [];
        foreach ($arrDestinations as $destination) {
            $arrCountryIds[] = $this->objValidatingForeignKeyService->validateCountry($destination , "Test Country");
        }
        return $arrCountryIds;
    }

    /**
     * @param array $arrItineraries
     * @return array
     */
    public function getItineraries(array $arrItineraries):array{
        $objItineraries = [];
        foreach ($arrItineraries as $arrItinerary) {
            $objItinerary = [];
            $objItinerary['day'] = $arrItinerary['Day'];
            $objItinerary['description'] = $arrItinerary['Description'];
            $objItinerary['meals'] =
                "Breakfast: " . ($arrItinerary['Breakfast'] ? "Available" : "Nill") . ", " .
                "Lunch: " . ($arrItinerary['Lunch'] ? "Available" : "Nill") . ", " .
                "Dinner: " . ($arrItinerary['Dinner'] ? "Available" : "Nill") . ", ";
            $objItinerary['hotel_names'] = null;
            $objItinerary['optional'] = null;
            array_push($objItineraries , $objItinerary);
        }
        return $objItineraries;
    }

    /**
     * @param array $arrTourDates
     * @return array
     */
    public function getTourDepartureDates(array $arrTourDates):array{
        $objTourDates = [];
        foreach ($arrTourDates as $arrTourDate) {
            $objTourDate = [];
            $objTourDate['year'] = $this->getYearFromDate($arrTourDate['TourDate']);
            $objTourDate['start_date'] = $arrTourDate['DepartureDate'];
            $objTourDate['end_date'] = $arrTourDate['ReturnDate'];
            $objTourDate['availability'] = $arrTourDate['SaleStatus'];
            foreach ($arrTourDate['RoomPricing'] as $roomPricing) {
                $objTourDate['price'] =$roomPricing['PriceAdultLandPerPerson'] + $roomPricing['PriceAdultRequiredSupplementPerPerson'];
            }
            array_push($objTourDates , $objTourDate);
        }
        return $objTourDates;
    }

    /**
     * @param $dateString
     * @return string
     */
    function getYearFromDate($dateString) {
        $date = \DateTime::createFromFormat('m/d/Y', $dateString);
        return $date->format('Y');
    }

    /**
     * @param array $arrImages
     * @return array
     */
    function getSliderOrGallery(array $arrImages): array{
        $objImages = [];
        foreach ($arrImages as $arrImage) {
            if ($arrImage['ImageType'] !== "Map" && $arrImage['ImageType'] !== "Hi Res Image"){
                $url= $arrImage['Url'];
                array_push($objImages , $url);
            }
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
            if ($arrImage['ImageType'] !== "Map" && $arrImage['ImageType'] !== "Hi Res Image"){
                $url = $arrImage['Url'];
                break;
            }
        }
        return $url;
    }

    /**
     * @param array $arrImages
     * @param array $arrItineraries
     * @return array
     */
    public function getTourLocation(array $arrImages , array $arrItineraries): array{
        $objLocations = [];
        foreach ($arrImages as $arrImage) {
            if ($arrImage['ImageType'] === "Map"){
                $objLocationImage = [];
                $objLocationImage['map_image'] = $arrImage['Url'];
                $objLocationImage['lat'] = $arrImage['Url'];
                $objLocationImage['long'] = $arrImage['Url'];
                array_push($objLocations , $objLocationImage);
            }
        }
        if(empty($objLocations)){
            foreach ($arrItineraries as $arrItinerary) {
                $objLocation = [];
                $objLocation['long'] = $arrItinerary['Longitude'];
                $objLocation['lat'] = $arrItinerary['Latitude'];
                array_push($objLocations , $objLocation);
            }
        }
        return $objLocations;
    }

}



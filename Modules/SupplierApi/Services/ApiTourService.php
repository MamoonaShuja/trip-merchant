<?php
namespace Modules\SupplierApi\Services;


use Illuminate\Contracts\Container\Container;
use Modules\SupplierApi\Contracts\Services\ApiTourContract;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\SupplierApi\Entities\ApiSupplier;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Contracts\Services\AccommodationContract;
use Modules\Tour\Contracts\Services\CabinDeckContract;
use Modules\Tour\Contracts\Services\DepartureDateContract;
use Modules\Tour\Contracts\Services\EssentialInfoContract;
use Modules\Tour\Contracts\Services\ItineraryContract;
use Modules\Tour\Contracts\Services\LocationContract;
use Modules\Tour\Contracts\Services\VideoContract;
use Modules\Tour\Entities\Tour;

class ApiTourService implements ApiTourContract
{

        private TourRepositoryContract $objTourRepository;
        private ItineraryContract $objItineraryService;
        private DepartureDateContract $objDepartureDateService;
        private AccommodationContract $objAccommodationService;
        private LocationContract $objLocationService;
        private EssentialInfoContract $objEssentialInfoService;
        private CabinDeckContract $objCabinDeckService;
        private VideoContract $objVideoService;
    public function initializeContainers(Container $container):void{

        $this->objTourRepository = $container->make(TourRepositoryContract::class);
        $this->objItineraryService = $container->make(ItineraryContract::class);
        $this->objDepartureDateService = $container->make(DepartureDateContract::class);
        $this->objAccommodationService = $container->make(AccommodationContract::class);
        $this->objLocationService = $container->make(LocationContract::class);
        $this->objEssentialInfoService = $container->make(EssentialInfoContract::class);
        $this->objCabinDeckService = $container->make(CabinDeckContract::class);
        $this->objVideoService = $container->make(VideoContract::class);
      }


    /**
     * @param ApiSupplier $objApiSupplier
     * @param ApiTourDTO $objApiTourDTO
     * @return void
     */
    public function saveTour(ApiSupplier $objApiSupplier , ApiTourDTO $objApiTourDTO , Container $container):void{
        $this->initializeContainers($container);
        $objTour = $this->objTourRepository->create(
            $objApiTourDTO->getObjAdmin(),
            $objApiTourDTO->getTitle(),
            $objApiTourDTO->getMembersRate(),
            $objApiTourDTO->getDiscountMembersRate(),
            $objApiTourDTO->getMembersBenefit(),
            $objApiTourDTO->getTotalDays(),
            $objApiTourDTO->getTotalNights(),
            $objApiTourDTO->getTermsAndConditions(),
            $objApiTourDTO->getOverview(),
            $objApiTourDTO->getHighlights(),
            $objApiTourDTO->getIncluded(),
            $objApiTourDTO->getDepositAndPayments(),
            $objApiTourDTO->getNotIncluded(),
            $objApiTourDTO->getTotalMeals(),
            $objApiTourDTO->getActivityLevel(),
            $objApiTourDTO->getPassengerLimit(),
            $objApiTourDTO->getUpgrades(),
            $objApiTourDTO->getAgeRange(),
            $objApiTourDTO->getIsVisible(),
            $objApiTourDTO->getTravelStyleId(),
            $objApiTourDTO->getApiSupplierId(),
            $objApiTourDTO->getApiTourId(),
        );
        if(!is_null($objApiTourDTO->getItinerary()))
            $this->objItineraryService->saveItineraries($objTour , $objApiTourDTO);
        if(!is_null($objApiTourDTO->getDepartureDates()))
            $this->objDepartureDateService->saveDepartureDates($objTour , $objApiTourDTO);
        if(!is_null($objApiTourDTO->getAccommodations()))
            $this->objAccommodationService->saveAccommodations($objTour , $objApiTourDTO);
        if(!is_null($objApiTourDTO->getLocations()))
            $this->objLocationService->saveLocations($objTour , $objApiTourDTO);
        if(!is_null($objApiTourDTO->getEssentialInfo()))
            $this->objEssentialInfoService->saveEssentialInfos($objTour , $objApiTourDTO);
        if(!is_null($objApiTourDTO->getCabinDecks()))
            $this->objCabinDeckService->saveCabinDecks($objTour , $objApiTourDTO);
        if(!is_null($objApiTourDTO->getVideos()))
            $this->objVideoService->saveVideos($objTour , $objApiTourDTO);
        if(!is_null($objApiTourDTO->getOrganizations()))
            $this->objTourRepository->saveOrganizations($objTour , $objApiTourDTO->getOrganizations());
        if(!is_null($objApiTourDTO->getCountries()))
            $this->objTourRepository->saveCountries($objTour , $objApiTourDTO->getCountries());
        if(!is_null($objApiTourDTO->getArrivalCities()))
            $this->objTourRepository->saveArrivalCities($objTour , $objApiTourDTO->getArrivalCities());
        if(!is_null($objApiTourDTO->getDepartureCities()))
            $this->objTourRepository->saveDepartureCities($objTour , $objApiTourDTO->getDepartureCities());
        if(!is_null($objApiTourDTO->getDestinations()))
            $this->objTourRepository->saveDestinations($objTour , $objApiTourDTO->getDestinations());
        if(!is_null($objApiTourDTO->getImage()))
            $objTour->setFeaturedImage($objApiTourDTO->getImage());
        if(!is_null($objApiTourDTO->getGalleryFiles()))
            $this->saveGallery($objTour , $objApiTourDTO->getGalleryFiles());
        if(!is_null($objApiTourDTO->getSliderFiles()))
            $this->saveSlider($objTour , $objApiTourDTO->getSliderFiles());
    }
    /**
     * @param Tour $objTour
     * @param array $gallery
     * @return void
     */
    public function saveGallery(Tour $objTour , array $gallery):void{
        foreach ($gallery as $item) {
            $objTour->setGallery($item);
        }
    }


    /**
     * @param Tour $objTour
     * @param array $slider
     * @return void
     */
    public function saveSlider(Tour $objTour , array $slider):void{
        foreach ($slider as $item) {
            $objTour->setSlider($item);
        }
    }
}


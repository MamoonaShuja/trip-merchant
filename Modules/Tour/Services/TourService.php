<?php

namespace Modules\Tour\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Contracts\Services\AccommodationContract;
use Modules\Tour\Contracts\Services\DepartureDateContract;
use Modules\Tour\Contracts\Services\EssentialInfoContract;
use Modules\Tour\Contracts\Services\ItineraryContract;
use Modules\Tour\Contracts\Services\LocationContract;
use Modules\Tour\Contracts\Services\TourContract;
use Modules\Tour\Contracts\Services\VideoContract;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\DataTransfer\Requests\TravelStyleDTO;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TravelStyle;
use Modules\User\Entities\User;

class TourService implements TourContract
{
    public function __construct(
        //Repositories
        private readonly TourRepositoryContract $objTourRepository,
        private readonly ItineraryContract      $objItineraryService,
        private readonly DepartureDateContract  $objDepartureDateService,
        private readonly AccommodationContract  $objAccommodationService,
        private readonly LocationContract       $objLocationService,
        private readonly EssentialInfoContract  $objEssentialInfoService,
        private readonly CabinDeckService       $objCabinDeckService,
        private readonly VideoContract          $objVideoService,
    )
    {
    }


    /**
     * @param User $objUser
     * @param TourDTO $objTourDto
     * @return Tour
     */
    public function create(User $objUser, TourDTO $objTourDto): Tour
    {
        $objTour = $this->objTourRepository->create(
            $objUser,
            $objTourDto->getTitle(),
            $objTourDto->getMembersRate(),
            $objTourDto->getDiscountMembersRate(),
            $objTourDto->getMembersBenefit(),
            $objTourDto->getTotalDays(),
            $objTourDto->getTotalNights(),
            $objTourDto->getTermsAndConditions(),
            $objTourDto->getOverview(),
            $objTourDto->getHighlights(),
            $objTourDto->getIncluded(),
            $objTourDto->getDepositAndPayments(),
            $objTourDto->getNotIncluded(),
            $objTourDto->getTotalMeals(),
            $objTourDto->getActivityLevel(),
            $objTourDto->getPassengerLimit(),
            $objTourDto->getUpgrades(),
            $objTourDto->getAgeRange(),
            $objTourDto->getIsVisible(),
            $objTourDto->getTravelStyleId(),
            null,
            null
        );
        if (!is_null($objTourDto->getItinerary()))
            $this->objItineraryService->saveItineraries($objTour, $objTourDto);
        if (!is_null($objTourDto->getDepartureDates()))
            $this->objDepartureDateService->saveDepartureDates($objTour, $objTourDto);
        if (!is_null($objTourDto->getAccommodations()))
            $this->objAccommodationService->saveAccommodations($objTour, $objTourDto);
        if (!is_null($objTourDto->getLocations()) || !is_null($objTourDto->getLocationMapImages()))
            $this->objLocationService->saveLocations($objTour, $objTourDto);
        if (!is_null($objTourDto->getEssentialInfo()))
            $this->objEssentialInfoService->saveEssentialInfos($objTour, $objTourDto);
        if (!is_null($objTourDto->getCabinDecks()))
            $this->objCabinDeckService->saveCabinDecks($objTour, $objTourDto);
        if (!is_null($objTourDto->getVideos()))
            $this->objVideoService->saveVideos($objTour, $objTourDto);
        if (!is_null($objTourDto->getOrganizations()))
            $this->objTourRepository->saveOrganizations($objTour, $objTourDto->getOrganizations());
        if (!is_null($objTourDto->getCountries()))
            $this->objTourRepository->saveCountries($objTour, $objTourDto->getCountries());
        if (!is_null($objTourDto->getArrivalCities()))
            $this->objTourRepository->saveArrivalCities($objTour, $objTourDto->getArrivalCities());
        if (!is_null($objTourDto->getDepartureCities()))
            $this->objTourRepository->saveDepartureCities($objTour, $objTourDto->getDepartureCities());
        if (!is_null($objTourDto->getDestinations()))
            $this->objTourRepository->saveDestinations($objTour, $objTourDto->getDestinations());
        if (!is_null($objTourDto->getImage()))
            $objTour->setFeaturedImage($objTourDto->getImage());
        if (!is_null($objTourDto->getGalleryFiles()))
            $this->saveGallery($objTour, $objTourDto->getGalleryFiles());
        if (!is_null($objTourDto->getSliderFiles()))
            $this->saveSlider($objTour, $objTourDto->getSliderFiles());
        return $objTour;
    }


    /**
     * @return Collection
     */
    public function get(User|null $objUser): LengthAwarePaginator|null
    {
        return $this->objTourRepository->getTrips($objUser);
    }

    /**
     * @param User|null $objUser
     * @return LengthAwarePaginator|null
     */
    public function getWithDeals(User|null $objUser): LengthAwarePaginator|null
    {
        return $this->objTourRepository->getTripsWithDeals($objUser);

    }


    public function getDeleted(): LengthAwarePaginator|null
    {
        return $this->objTourRepository->getDeleted();
    }

    /**
     * @param string $id
     * @return Tour|null
     */
    public function findByUuid(string $id): ?Tour
    {
        return $this->objTourRepository->findByUuid($id);
    }

    /**
     * @param string|null $strSlug
     * @return Tour|null
     */
    public function findBySlug(string|null $strSlug): Tour|null
    {
        return $this->objTourRepository->findBySlug($strSlug);
    }

    /**
     * @param TravelStyle $travelStyle
     * @return bool|null
     */
    public function delete(Tour $objTour): ?bool
    {
        return $this->objTourRepository->delete($objTour);
    }

    /**
     * @param TravelStyle $objTravelStyle
     * @param TravelStyleDTO $updateTravelStyleDTO
     * @return TravelStyle
     */
    public function update(Tour $objTour, TourDTO $objTourDto): Tour
    {
        $this->objTourRepository->update(
            $objTour,
            $objTourDto->getTitle(),
            $objTourDto->getMembersRate(),
            $objTourDto->getDiscountMembersRate(),
            $objTourDto->getMembersBenefit(),
            $objTourDto->getTotalDays(),
            $objTourDto->getTotalNights(),
            $objTourDto->getTermsAndConditions(),
            $objTourDto->getOverview(),
            $objTourDto->getHighlights(),
            $objTourDto->getIncluded(),
            $objTourDto->getDepositAndPayments(),
            $objTourDto->getNotIncluded(),
            $objTourDto->getTotalMeals(),
            $objTourDto->getActivityLevel(),
            $objTourDto->getPassengerLimit(),
            $objTourDto->getUpgrades(),
            $objTourDto->getAgeRange(),
            $objTourDto->getIsVisible(),
            $objTourDto->getTravelStyleId(),
        );
        if (!is_null($objTourDto->getItinerary()))
            $this->objItineraryService->updateItineraries($objTour, $objTourDto);
        if (!is_null($objTourDto->getDepartureDates()))
            $this->objDepartureDateService->updateDepartureDates($objTour, $objTourDto);
        if (!is_null($objTourDto->getAccommodations()))
            $this->objAccommodationService->updateAccommodations($objTour, $objTourDto);
        if (!is_null($objTourDto->getLocations()))
            $this->objLocationService->updateLocations($objTour, $objTourDto);
        if (!is_null($objTourDto->getEssentialInfo()))
            $this->objEssentialInfoService->updateEssentialInfos($objTour, $objTourDto);
        if (!is_null($objTourDto->getCabinDecks()))
            $this->objCabinDeckService->updateCabinDeck($objTour, $objTourDto);
        if (!is_null($objTourDto->getVideos()))
            $this->objVideoService->updateVideos($objTour, $objTourDto);
        if (!is_null($objTourDto->getOrganizations()))
            $this->objTourRepository->saveOrganizations($objTour, $objTourDto->getOrganizations());
        if (!is_null($objTourDto->getCountries()))
            $this->objTourRepository->saveCountries($objTour, $objTourDto->getCountries());
        if (!is_null($objTourDto->getArrivalCities()))
            $this->objTourRepository->saveArrivalCities($objTour, $objTourDto->getArrivalCities());
        if (!is_null($objTourDto->getDepartureCities()))
            $this->objTourRepository->saveDepartureCities($objTour, $objTourDto->getDepartureCities());
        if (!is_null($objTourDto->getDestinations()))
            $this->objTourRepository->saveDestinations($objTour, $objTourDto->getDestinations());
        if (!is_null($objTourDto->getImage()))
            $objTour->updateFeaturedImage($objTourDto->getImage());

        return $objTour;
    }

    /**
     * @param Tour $objTour
     * @param array $gallery
     * @return void
     */
    public function saveGallery(Tour $objTour, array $gallery): void
    {
        foreach ($gallery as $item) {
            $objTour->setGallery($item);
        }
    }


    /**
     * @param Tour $objTour
     * @param array $slider
     * @return void
     */
    public function saveSlider(Tour $objTour, array $slider): void
    {
        foreach ($slider as $item) {
            $objTour->setSlider($item);
        }
    }


}

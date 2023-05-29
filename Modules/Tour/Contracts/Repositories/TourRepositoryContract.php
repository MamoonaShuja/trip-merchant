<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Tour\Entities\Tour;
use Modules\User\Entities\User;

interface TourRepositoryContract
{
    /**
     * @param User $objUser
     * @param string|null $strTitle
     * @param string|null $strMembersRate
     * @param string|null $strDiscountMembersRate
     * @param string|null $strMembersBenefit
     * @param string|null $strTotalDays
     * @param string|null $strTotalNights
     * @param string|null $strTermsAndConditions
     * @param string|null $strOverview
     * @param string|null $strHighlights
     * @param string|null $strIncluded
     * @param string|null $strDepositAndPayments
     * @param string|null $strNotIncluded
     * @param string|null $strTotalMeals
     * @param string|null $strActivityLevel
     * @param string|null $strPassengerLimit
     * @param string|null $strUpgrades
     * @param string|null $strAgeRange
     * @param bool $strIsVisible
     * @param string|null $strArrivalCityId
     * @param string|null $strDepartureCityId
     * @param string|null $strCountryId
     * @param string|null $strTravelStyleId
     * @param string|null $strDestinationId
     * @param string|null $strSupplierApiId
     * @param string|null $strApiTourId
     * @return Tour
     */
    public function create(
        User        $objUser,
        string|null $strTitle,
        string|null $strMembersRate,
        string|null $strDiscountMembersRate,
        string|null $strMembersBenefit,
        string|null $strTotalDays,
        string|null $strTotalNights,
        string|null $strTermsAndConditions,
        string|null $strOverview,
        string|null $strHighlights,
        string|null $strIncluded,
        string|null $strDepositAndPayments,
        string|null $strNotIncluded,
        string|null $strTotalMeals,
        string|null $strActivityLevel,
        string|null $strPassengerLimit,
        string|null $strUpgrades,
        string|null $strAgeRange,
        bool        $strIsVisible,
        string|null $strTravelStyleId,
        string|null $strSupplierApiId,
        string|null $strApiTourId,
    ): Tour;

    /**
     * @return Collection|null
     */
    public function getTrips(User|null $objUser): LengthAwarePaginator|null;

    /**
     * @param User|null $objUser
     * @return LengthAwarePaginator|null
     */
    public function getTripsWithDeals(User|null $objUser): LengthAwarePaginator|null;

    /**
     * @return LengthAwarePaginator|null
     */
    public function getDeleted(): LengthAwarePaginator|null;

    /**
     * @param string|null $id
     * @return Tour|null
     */
    public function findByUuid(string|null $id): Tour|null;

    /**X
     * @param string|null $strSlug
     * @return Tour|null
     */
    public function findBySlug(string|null $strSlug): Tour|null;

    /**
     * @param Tour $tour
     * @return bool
     */
    public function delete(Tour $tour): bool;

    /**
     * @param Tour $objTour
     * @param string|null $strTitle
     * @param string|null $strMembersRate
     * @param string|null $strDiscountMembersRate
     * @param string|null $strMembersBenefit
     * @param string|null $strTotalDays
     * @param string|null $strTotalNights
     * @param string|null $strTermsAndConditions
     * @param string|null $strOverview
     * @param string|null $strHighlights
     * @param string|null $strIncluded
     * @param string|null $strDepositAndPayments
     * @param string|null $strNotIncluded
     * @param string|null $strTotalMeals
     * @param string|null $strActivityLevel
     * @param string|null $strPassengerLimit
     * @param string|null $strUpgrades
     * @param string|null $strAgeRange
     * @param bool|null $strIsVisible
     * @param string|null $strArrivalCityId
     * @param string|null $strDepartureCityId
     * @param string|null $strTravelStyleId
     * @param string|null $strDestinationId
     * @return Tour
     */
    public function update(
        Tour        $objTour,
        string|null $strTitle,
        string|null $strMembersRate,
        string|null $strDiscountMembersRate,
        string|null $strMembersBenefit,
        string|null $strTotalDays,
        string|null $strTotalNights,
        string|null $strTermsAndConditions,
        string|null $strOverview,
        string|null $strHighlights,
        string|null $strIncluded,
        string|null $strDepositAndPayments,
        string|null $strNotIncluded,
        string|null $strTotalMeals,
        string|null $strActivityLevel,
        string|null $strPassengerLimit,
        string|null $strUpgrades,
        string|null $strAgeRange,
        bool        $strIsVisible,
        string|null $strTravelStyleId,
    ): Tour;

    /**
     * @param array $objItineraries
     * @return mixed
     */
    public function saveItineraries(Tour $tour, array $objItineraries): Collection;

    /**
     * @param array $objDeparturesDates
     * @return mixed
     */
    public function saveDepartureDates(Tour $objTour, array $objDeparturesDates): Collection;

    /**
     * @param array $objAccommodations
     * @return mixed
     */
    public function saveAccommodations(Tour $objTour, array $objAccommodations): Collection;

    /**
     * @param array $objLocations
     * @return mixed
     */
    public function saveLocations(Tour $objTour, array $objLocations): Collection;

    /**
     * @param Tour $objTour
     * @param array $objEssentialInfos
     * @return Collection
     */
    public function saveEssentialInfos(Tour $objTour, array $objEssentialInfos): Collection;

    /**
     * @param Tour $objTour
     * @param array $objCabinDecks
     * @return Collection
     */
    public function saveCabinDecks(Tour $objTour, array $objCabinDecks): Collection;

    /**
     * @param array $objVideos
     * @return mixed
     */
    public function saveVideos(Tour $objTour, array $objVideos): Collection;

    public function updateItineraries(Tour $tour, array $objItineraries): Collection;

    /**
     * @param array $objDeparturesDates
     * @return mixed
     */
    public function updateDepartureDates(Tour $objTour, array $objDeparturesDates): Collection;

    /**
     * @param array $objAccommodations
     * @return mixed
     */
    public function updateAccommodations(Tour $objTour, array $objAccommodations): Collection;

    /**
     * @param array $objLocations
     * @return mixed
     */
    public function updateLocations(Tour $objTour, array $objLocations): Collection;

    /**
     * @param Tour $objTour
     * @param array $objEssentialInfos
     * @return Collection
     */
    public function updateEssentialInfos(Tour $objTour, array $objEssentialInfos): Collection;

    /**
     * @param array $objVideos
     * @return mixed
     */
    public function updateVideos(Tour $objTour, array $objVideos): Collection;

    /**
     * @param Tour $objTour
     * @param array $objOrganizations
     * @return Collection
     */
    public function saveOrganizations(Tour $objTour, array $arrOrganizations): void;

    /**
     * @param Tour $objTour
     * @param array $arrCountries
     * @return void
     */
    public function saveCountries(Tour $objTour, array $arrCountries): void;

    /**
     * @param Tour $objTour
     * @param array $arrArrivalCities
     * @return void
     */
    public function saveArrivalCities(Tour $objTour, array $arrArrivalCities): void;

    /**
     * @param Tour $objTour
     * @param array $arrDepartureCities
     * @return void
     */
    public function saveDepartureCities(Tour $objTour, array $arrDepartureCities): void;

    /**
     * @param Tour $objTour
     * @param array $arrDestinations
     * @return void
     */
    public function saveDestinations(Tour $objTour, array $arrDestinations): void;

}

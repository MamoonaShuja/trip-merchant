<?php

namespace Modules\Tour\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Enum\CityTypes;
use Modules\User\Contracts\Repositories\UserRepositoryContract;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;

class TourRepository implements TourRepositoryContract
{
    public function __construct(private readonly Tour $model, private readonly UserRepositoryContract $objUserRepository)
    {
    }


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
    ): Tour
    {
        $objQuery = $this->model->newQuery();
        $objTour = $objQuery->create([
            'title' => $strTitle,
            'members_rate' => $strMembersRate,
            'discount_members_rate' => $strDiscountMembersRate,
            'members_benefit' => $strMembersBenefit,
            'total_days' => $strTotalDays,
            'total_nights' => $strTotalNights,
            'terms_and_conditions' => $strTermsAndConditions,
            'overview' => $strOverview,
            'highlights' => $strHighlights,
            'included' => $strIncluded,
            'deposit_and_payments' => $strDepositAndPayments,
            'not_included' => $strNotIncluded,
            'total_meals' => $strTotalMeals,
            'activity_level' => $strActivityLevel,
            'passenger_limit' => $strPassengerLimit,
            'upgrades' => $strUpgrades,
            'age_range' => $strAgeRange,
            'is_visible' => $strIsVisible,
            'travel_style_id' => $strTravelStyleId,
            'tour_uuid' => Str::uuid(),
            "supplier_id" => $objUser->id,
            "api_supplier_id" => $strSupplierApiId,
            "api_tour_id" => $strApiTourId,
        ]);

        return $objTour;
    }

    /**
     * @return Collection|null
     */
    /**
     * Get trips with pagination.
     *
     * @param User|null $objUser
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getTrips(User|null $objUser): LengthAwarePaginator|null
    {
        $perPage = env("PER_PAGE_TOURS");
        $objQuery = $this->model->newQuery();
        if (is_null($objUser)) {
            return $objQuery->latest()->with(
                [
                    'accommodations',
                    'departureDates',
                    'essentialInfos',
                    'faqs',
                    'itinarary',
                    'locations',
                    'reviews',
                    'videos',
                    'travelStyle',
                    'arrivalCities',
                    'departureCities',
                    'destinations',
                    'cabinDecks',
                    'organizations',
                    'countries'
                ]
            )->paginate($perPage);

        }
        return $objUser->role->name == UserType::ADMIN->value
            ?
            $objQuery->latest()->with(
                [
                    'accommodations',
                    'departureDates',
                    'essentialInfos',
                    'faqs',
                    'itinarary',
                    'locations',
                    'reviews',
                    'videos',
                    'travelStyle',
                    'arrivalCities',
                    'departureCities',
                    'destinations',
                    'cabinDecks',
                    'organizations',
                    'countries'
                ]
            )->paginate($perPage)
            : $objQuery->latest()->with([
                'accommodations',
                'departureDates',
                'essentialInfos',
                'faqs',
                'itinarary',
                'locations',
                'reviews',
                'videos',
                'travelStyle',
                'arrivalCities',
                'departureCities',
                'destinations',
                'cabinDecks',
                'organizations',
                'countries'
            ])->whereSupplierId($objUser->id)->paginate($perPage);
    }

    public function getTripsWithDeals(User|null $objUser): LengthAwarePaginator|null
    {
        $perPage = env("PER_PAGE_TOURS");
        $objQuery = $this->model->newQuery();
        if (is_null($objUser)) {
            return $objQuery->latest()->with(
                [
                    'accommodations',
                    'departureDates',
                    'essentialInfos',
                    'faqs',
                    'itinarary',
                    'locations',
                    'reviews',
                    'videos',
                    'travelStyle',
                    'arrivalCities',
                    'departureCities',
                    'destinations',
                    'cabinDecks',
                    'organizations',
                    'countries'
                ]
            )->where('discount_members_rate', '!=', null)->paginate($perPage);

        }
        return $objUser->role->name == UserType::ADMIN->value
            ? $objQuery->latest()->with(
                [
                    'accommodations',
                    'departureDates',
                    'essentialInfos',
                    'faqs',
                    'itinarary',
                    'locations',
                    'reviews',
                    'videos',
                    'travelStyle',
                    'arrivalCities',
                    'departureCities',
                    'destinations',
                    'cabinDecks',
                    'organizations',
                    'countries'
                ]
            )->where('discount_members_rate', '!=', null)->paginate($perPage)
            : $objQuery->latest()->with([
                'accommodations',
                'departureDates',
                'essentialInfos',
                'faqs',
                'itinarary',
                'locations',
                'reviews',
                'videos',
                'travelStyle',
                'arrivalCities',
                'departureCities',
                'destinations',
                'cabinDecks',
                'organizations',
                'countries'
            ])->whereSupplierId($objUser->id)->where('discount_members_rate', '!=', null)->paginate($perPage);
    }


    public function getDeleted(): LengthAwarePaginator|null
    {
        $objQuery = $this->model->newQuery();
        return
            Auth::user()->role->name == UserType::ADMIN->value
                ?
                $objQuery->latest()->onlyTrashed()->paginate(env("PER_PAGE_TOURS"))
                :
                $objQuery->latest()->whereSupplierId(Auth::user()->id)->paginate(env("PER_PAGE_TOURS"))->onlyTrashed();
    }

    /**
     * @param string|null $id
     * @return Tour|null
     */
    public function findByUuid(string|null $id): Tour|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereTourUuid($id)->first();
    }

    /**
     * @param string|null $strSlug
     * @return Tour|null
     */
    public function findBySlug(string|null $strSlug): Tour|null
    {
        $objQuery = $this->model->newQuery();
        return $objQuery->whereSlug($strSlug)->first();
    }

    /**
     * @param Tour $tour
     * @return bool
     */
    public function delete(Tour $tour): bool
    {
        return $tour->delete();
    }

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
     * @param string|null $strHealthAndSafety
     * @param string|null $strArrivalCityId
     * @param string|null $strDepartureCityId
     * @param string|null $strTravelStyleId
     * @param string|null $strDestinationId
     * @return Tour
     */
    public function update(Tour        $objTour,
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
                           ?bool       $strIsVisible,
                           string|null $strTravelStyleId,
    ): Tour
    {
        if (is_string($strTitle) && $objTour->first_name !== $strTitle) {
            $objTour->title = $strTitle;
        }
        if (is_string($strMembersRate) && $objTour->last_name !== $strMembersRate) {
            $objTour->members_rate = $strMembersRate;
        }

        if (is_string($strDiscountMembersRate) && $objTour->email !== $strDiscountMembersRate) {
            $objTour->discount_members_rate = $strDiscountMembersRate;
        }

        if (is_string($strMembersBenefit) && $objTour->members_benefit !== $strMembersBenefit) {
            $objTour->members_benefit = $strMembersBenefit;
        }

        if (is_string($strTotalDays) && $objTour->total_days !== $strTotalDays) {
            $objTour->total_days = $strTotalDays;
        }
        if (is_string($strTotalNights) && $objTour->total_nights !== $strTotalNights) {
            $objTour->total_nights = $strTotalNights;
        }
        if (is_string($strTermsAndConditions) && $objTour->terms_and_conditions !== $strTermsAndConditions) {
            $objTour->terms_and_conditions = $strTermsAndConditions;
        }
        if (is_string($strOverview) && $objTour->overview !== $strOverview) {
            $objTour->overview = $strOverview;
        }
        if (is_string($strHighlights) && $objTour->highlights !== $strHighlights) {
            $objTour->highlights = $strHighlights;
        }
        if (is_string($strIncluded) && $objTour->included !== $strIncluded) {
            $objTour->included = $strIncluded;
        }
        if (is_string($strNotIncluded) && $objTour->not_included !== $strNotIncluded) {
            $objTour->not_included = $strNotIncluded;
        }
        if (is_string($strDepositAndPayments) && $objTour->deposit_and_payments !== $strDepositAndPayments) {
            $objTour->deposit_and_payments = $strDepositAndPayments;
        }
        if (is_string($strTotalMeals) && $objTour->total_meals !== $strTotalMeals) {
            $objTour->total_meals = $strTotalMeals;
        }
        if (is_string($strActivityLevel) && $objTour->activity_level !== $strActivityLevel) {
            $objTour->activity_level = $strActivityLevel;
        }
        if (is_string($strPassengerLimit) && $objTour->passenger_limit !== $strPassengerLimit) {
            $objTour->passenger_limit = $strPassengerLimit;
        }
        if (is_string($strUpgrades) && $objTour->upgrades !== $strUpgrades) {
            $objTour->upgrades = $strUpgrades;
        }
        if (is_string($strAgeRange) && $objTour->age_range !== $strAgeRange) {
            $objTour->age_range = $strAgeRange;
        }
        if (is_string($strIsVisible) && $objTour->is_visible !== $strIsVisible) {
            $objTour->is_visible = $strIsVisible;
        }
        if (is_string($strTravelStyleId) && $objTour->travel_style_id !== $strTravelStyleId) {
            $objTour->travel_style_id = $strTravelStyleId;
        }

        $objTour->save();
        return $objTour;
    }

    /**
     * @param Tour $objTour
     * @param array $objItineraries
     * @return Collection
     */
    public function saveItineraries(Tour $objTour, array $objItineraries): Collection
    {
        $objTour->itinarary()->saveMany($objItineraries);
        return $objTour->itinarary()->get();
    }

    /**
     * @param Tour $objTour
     * @param array $objDeparturesDates
     * @return Collection
     */
    public function saveDepartureDates(Tour $objTour, array $objDeparturesDates): Collection
    {
        $objTour->departureDates()->saveMany($objDeparturesDates);
        return $objTour->departureDates()->get();
    }

    /**
     * @param Tour $objTour
     * @param array $objAccommodations
     * @return Collection
     */
    public function saveAccommodations(Tour $objTour, array $objAccommodations): Collection
    {
        $objTour->accommodations()->saveMany($objAccommodations);
        return $objTour->accommodations()->get();

    }

    /**
     * @param Tour $objTour
     * @param array $objLocations
     * @return Collection
     */
    public function saveLocations(Tour $objTour, array $objLocations): Collection
    {
        $objTour->locations()->saveMany($objLocations);
        return $objTour->locations()->get();

    }

    /**
     * @param Tour $objTour
     * @param array $objEssentialInfos
     * @return Collection
     */
    public function saveEssentialInfos(Tour $objTour, array $objEssentialInfos): Collection
    {
        $objTour->essentialInfos()->saveMany($objEssentialInfos);
        return $objTour->essentialInfos()->get();

    }

    /**
     * @param Tour $objTour
     * @param array $objCabinDecks
     * @return Collection
     */
    public function saveCabinDecks(Tour $objTour, array $objCabinDecks): Collection
    {
        $objTour->cabinDecks()->saveMany($objCabinDecks);
        return $objTour->cabinDecks()->get();

    }

    /**
     * @param Tour $objTour
     * @param array $objVideos
     * @return Collection
     */
    public function saveVideos(Tour $objTour, array $objVideos): Collection
    {
        $objTour->videos()->saveMany($objVideos);
        return $objTour->videos()->get();

    }

    /**
     * @param Tour $objTour
     * @param array $objItineraries
     * @return Collection
     */
    public function updateItineraries(Tour $objTour, array $objItineraryIds): Collection
    {
        $objTour->itinarary()->attach($objItineraryIds);
        return $objTour->itinarary()->get();
    }

    /**
     * @param Tour $objTour
     * @param array $objDeparturesDates
     * @return Collection
     */
    public function updateDepartureDates(Tour $objTour, array $objDeparturesDates): Collection
    {
        $objTour->itinarary()->update($objDeparturesDates);
        return $objTour->itinarary()->get();
    }

    /**
     * @param Tour $objTour
     * @param array $objAccommodations
     * @return Collection
     */
    public function updateAccommodations(Tour $objTour, array $objAccommodations): Collection
    {

        $objTour->accommodations()->sync($objAccommodations);
        return $objTour->accommodations()->get();
    }

    /**
     * @param Tour $objTour
     * @param array $objLocations
     * @return Collection
     */
    public function updateLocations(Tour $objTour, array $objLocations): Collection
    {

        $objTour->locations()->sync($objLocations);
        return $objTour->locations()->get();
    }

    /**
     * @param Tour $objTour
     * @param array $objEssentialInfos
     * @return Collection
     */
    public function updateEssentialInfos(Tour $objTour, array $objEssentialInfos): Collection
    {
        $objTour->essentialInfos()->sync($objEssentialInfos);
        return $objTour->essentialInfos()->get();
    }

    /**
     * @param Tour $objTour
     * @param array $objVideos
     * @return Collection
     */
    public function updateVideos(Tour $objTour, array $objVideos): Collection
    {
        $objTour->videos()->sync($objVideos);
        return $objTour->videos()->get();
    }

    /**
     * @param Tour $objTour
     * @param array $arrOrganizations
     * @return void
     */
    public function saveOrganizations(Tour $objTour, array $arrOrganizations): void
    {
        $arrOrganizationsIds = [];
        foreach ($arrOrganizations as $arrOrganization) {
            $arrOrganizationsIds[] = $this->objUserRepository->findByUuid($arrOrganization)->id;
        }
        $objTour->organizations()->sync($arrOrganizationsIds);
    }

    /**
     * @param Tour $objTour
     * @param array $arrCountries
     * @return void
     */
    public function saveCountries(Tour $objTour, array $arrCountries): void
    {
        $objTour->countries()->sync($arrCountries);
    }

    /**
     * @param Tour $objTour
     * @param array $arrDestinations
     * @return void
     */
    public function saveDestinations(Tour $objTour, array $arrDestinations): void
    {
        $objTour->destinations()->sync($arrDestinations);
    }

    /**
     * @param Tour $objTour
     * @param array $arrCities
     * @return void
     */
    public function saveArrivalCities(Tour $objTour, array $arrCities): void
    {
        $objTour->arrivalCities()->sync($arrCities);
    }

    /**
     * @param Tour $objTour
     * @param array $arrCities
     * @return void
     */
    public function saveDepartureCities(Tour $objTour, array $arrCities): void
    {
        $departureCities = [];
        foreach ($arrCities as $city) {
            $departureCities[$city] = ['type' => CityTypes::DEPARTURE_CITY];
        }
        $objTour->departureCities()->sync($departureCities);
    }

}

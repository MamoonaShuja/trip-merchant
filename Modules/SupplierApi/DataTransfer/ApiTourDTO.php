<?php
namespace Modules\SupplierApi\DataTransfer;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Modules\Core\DataTransfer\DTO;
use Modules\User\Entities\User;

class ApiTourDTO implements DTO
{
    /**
     * @param string|null $title
     * @param string|null $members_rate
     * @param string|null $discount_members_rate
     * @param string|null $members_benefit
     * @param string|null $total_days
     * @param string|null $total_nights
     * @param string|null $terms_and_conditions
     * @param string|null $overview
     * @param string|null $highlights
     * @param string|null $included
     * @param string|null $deposit_and_payments
     * @param string|null $not_included
     * @param string|null $total_meals
     * @param string|null $activity_level
     * @param string|null $passenger_limit
     * @param string|null $upgrades
     * @param string|null $age_range
     * @param string|null $is_visible
     * @param string|null $arrival_city_id
     * @param string|null $departure_city_id
     * @param string|null $country_id
     * @param string|null $travel_style_id
     * @param string|null $destination_id
     * @param array|null $itinerary
     * @param array|null $departure_dates
     * @param array|null $accommodations
     * @param array|null $locations
     * @param array|null $essential_info
     * @param array|null $cabinDecks
     * @param array|null $videos
     * @param array|null $organizations
     * @param array|null $galleryFiles
     * @param array|null $sliderFiles
     * @param array|null $cabinDeckFiles
     * @param array|null $essentialInfoFiles
     * @param string|null $api_supplier_id
     * @param string|null $api_tour_id
     * @param array|null $images
     * @param User $objAdmin
     */
    public function __construct(
        private readonly string|null $title,
        private readonly string|null $members_rate,
        private readonly string|null $discount_members_rate,
        private readonly string|null $members_benefit,
        private readonly string|null $total_days,
        private readonly string|null $total_nights,
        private readonly string|null $terms_and_conditions,
        private readonly string|null $overview,
        private readonly string|null $highlights,
        private readonly string|null $included,
        private readonly string|null $deposit_and_payments,
        private readonly string|null $not_included,
        private readonly string|null $total_meals,
        private readonly string|null $activity_level,
        private readonly string|null $passenger_limit,
        private readonly string|null $upgrades,
        private readonly string|null $age_range,
        private readonly string|null $is_visible,
        private readonly array|null $arrival_cities,
        private readonly array|null $departure_cities,
        private readonly array|null $countries,
        private readonly string|null $travel_style_id,
        private readonly array|null $destinations,
        private readonly array|null $itinerary,
        private readonly array|null $departure_dates,
        private readonly array|null $accommodations,
        private readonly array|null $locations,
        private readonly array|null $essential_info,
        private readonly array|null $cabinDecks,
        private readonly array|null $videos,
        private readonly array|null $organizations,
        private readonly array|null $galleryFiles, //
        private readonly array|null $sliderFiles, //
        private readonly array|null $cabinDeckFiles, //
        private readonly array|null $essentialInfoFiles, //
        private readonly string|null $api_supplier_id,
        private readonly string|null $api_tour_id,
        private readonly string|null $image,
        private readonly User $objAdmin
     ) {
    }

    /**
     * @param string|null $title
     * @param string|null $members_rate
     * @param string|null $discount_members_rate
     * @param string|null $members_benefit
     * @param string|null $total_days
     * @param string|null $total_nights
     * @param string|null $terms_and_conditions
     * @param string|null $overview
     * @param string|null $highlights
     * @param string|null $included
     * @param string|null $deposit_and_payments
     * @param string|null $not_included
     * @param string|null $total_meals
     * @param string|null $activity_level
     * @param string|null $passenger_limit
     * @param string|null $upgrades
     * @param string|null $age_range
     * @param string|null $is_visible
     * @param string|null $arrival_city_id
     * @param string|null $departure_city_id
     * @param string|null $country_id
     * @param string|null $travel_style_id
     * @param string|null $destination_id
     * @param array|null $itinerary
     * @param array|null $departure_dates
     * @param array|null $accommodations
     * @param array|null $locations
     * @param array|null $essential_info
     * @param array|null $cabinDecks
     * @param array|null $videos
     * @param array|null $organizations
     * @param array|null $galleryFiles
     * @param array|null $sliderFiles
     * @param array|null $cabinDeckFiles
     * @param array|null $essentialInfoFiles
     * @param string|null $api_supplier_id
     * @param string|null $api_tour_id
     * @param array|null $images
     * @param User $objAdmin
     * @return static
     */
    public static function create(
        string|null $title = null,
        string|null $members_rate = null,
        string|null $discount_members_rate = null,
        string|null $members_benefit = null,
        string|null $total_days = null,
        string|null $total_nights = null,
        string|null $terms_and_conditions = null,
        string|null $overview = null,
        string|null $highlights = null,
        string|null $included = null,
        string|null $deposit_and_payments = null,
        string|null $not_included = null,
        string|null $total_meals = null,
        string|null $activity_level = null,
        string|null $passenger_limit = null,
        string|null $upgrades = null,
        string|null $age_range = null,
        string|null $is_visible = null,
        array|null $arrival_cities = null,
        array|null $departure_cities = null,
        array|null $countries = null,
        string|null $travel_style_id = null,
        array|null $destinations = null,
        array|null $itinerary = null,
        array|null $departure_dates = null,
        array|null $accommodations = null,
        array|null $locations = null,
        array|null $essential_info = null,
        array|null $cabinDecks = null,
        array|null $videos = null,
        array|null $organizations = null,
        array|null $galleryFiles = null, //
        array|null $sliderFiles = null, //
        array|null $cabinDeckFiles = null, //
        array|null $essentialInfoFiles = null, //
        string|null $api_supplier_id,
        string|null $api_tour_id,
        string|null $image,
        User $objAdmin
    ): self
    {
        return new self($title , $members_rate , $discount_members_rate , $members_benefit , $total_days , $total_nights,
                $terms_and_conditions , $overview , $highlights , $included , $deposit_and_payments ,
                $not_included , $total_meals , $activity_level , $passenger_limit , $upgrades , $age_range , $is_visible ,  $arrival_cities , $departure_cities , $countries , $travel_style_id , $destinations ,$itinerary,
                $departure_dates,$accommodations,$locations,$essential_info,
            $cabinDecks , $videos,$organizations , $galleryFiles ,$sliderFiles,  $cabinDeckFiles , $essentialInfoFiles , $api_supplier_id,$api_tour_id,$image,$objAdmin
        );
    }

    /**
     * @return string
     */

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getMembersRate(): string|null
    {
        return $this->members_rate;
    }

    /**
     * @return string
     */
    public function getDiscountMembersRate(): string|null
    {
        return $this->discount_members_rate;
    }

    /**
     * @return string|null
     */
    public function getMembersBenefit(): string|null
    {
        return $this->members_benefit;
    }

    /**
     * @return string|null
     */
    public function getTotalDays(): string|null
    {
        return $this->total_days;
    }

    /**
     * @return string|null
     */
    public function getTotalNights(): string|null
    {
        return $this->total_nights;
    }

    /**
     * @return string|null
     */
    public function getTermsAndConditions(): string|null
    {
        return $this->terms_and_conditions;
    }

    /**
     * @return string|null
     */
    public function getDestinations(): array|null
    {
        return $this->destinations;
    }

    /**
     * @return string|null
     */
    public function getOverview(): string|null
    {
        return $this->overview;
    }

    /**
     * @return string|null
     */
    public function getTravelStyleId(): string|null
    {
        return $this->travel_style_id;
    }

    /**
     * @return string|null
     */
    public function getAgeRange(): string|null
    {
        return $this->age_range;
    }

    /**
     * @return string|null
     */
    public function getDepartureCities(): array|null
    {
        return $this->departure_cities;
    }

    /**
     * @return string|null
     */
    public function getArrivalCities(): array|null
    {
        return $this->arrival_cities;
    }

    /**
     * @return string|null
     */
    public function getHighlights(): string|null
    {
        return $this->highlights;
    }

    /**
     * @return string|null
     */
    public function getIncluded(): string|null
    {
        return $this->included;
    }

    /**
     * @return string|null
     */
    public function getDepositAndPayments(): string|null
    {
        return $this->deposit_and_payments;
    }

    /**
     * @return string|null
     */
    public function getNotIncluded(): string|null
    {
        return $this->not_included;
    }

    /**
     * @return string|null
     */
    public function getTotalMeals(): string|null
    {
        return $this->total_meals;
    }


    /**
     * @return string|null
     */
    public function getActivityLevel(): string|null
    {
        return $this->activity_level;
    }

    /**
     * @return string|null
     */
    public function getPassengerLimit(): string|null
    {
        return $this->passenger_limit;
    }

    /**
     * @return string|null
     */
    public function getUpgrades(): string|null
    {
        return $this->upgrades;
    }

    /**
     * @return string|null
     */
    public function getIsVisible(): string|null
    {
        return $this->is_visible;
    }

    /**
     * @return array|null
     */
    public function getItinerary(): array|null
    {
        return $this->itinerary;
    }

    /**
     * @param int $index
     * @return int|null
     */
    public function getItineraryId(int $index):int|null{
        return array_key_exists("id" , $this->getItinerary()[$index]) ? $this->getItinerary()[$index]['id'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getItineraryDay(int $index):string|null{
        return array_key_exists("day" , $this->getItinerary()[$index]) ? $this->getItinerary()[$index]['day'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getItineraryHotelName(int $index):string|null{
        return array_key_exists("hotel_names" , $this->getItinerary()[$index]) ? $this->getItinerary()[$index]['hotel_names'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getItineraryDescription(int $index):string|null{
        return array_key_exists("description" , $this->getItinerary()[$index]) ? $this->getItinerary()[$index]['description'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getItineraryMeal(int $index):string|null{
        return array_key_exists("meals" , $this->getItinerary()[$index]) ? $this->getItinerary()[$index]['meals'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getItineraryOptional(int $index):string|null {
        return array_key_exists("optional" , $this->getItinerary()[$index]) ? $this->getItinerary()[$index]['optional'] : null;
    }

    /**
     * @return array|null
     */
    public function getDepartureDates(): array|null
    {
        return $this->departure_dates;
    }

    /**
     * @param int $index
     * @return int|null
     */
    public function getDepartureDatesId(int $index):int|null{
        return array_key_exists("id" , $this->getDepartureDates()[$index]) ? $this->getDepartureDates()[$index]['id'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getDepartureDatesYear(int $index):string|null{
        return array_key_exists("year" , $this->getDepartureDates()[$index]) ? $this->getDepartureDates()[$index]['year'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getDepartureDatesStartDate(int $index):string|null{
        return array_key_exists("start_date" , $this->getDepartureDates()[$index]) ? $this->processDate($this->getDepartureDates()[$index]['start_date']) : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getDepartureDatesEndDate(int $index):string|null{
        return array_key_exists("end_date" , $this->getDepartureDates()[$index]) ? $this->processDate($this->getDepartureDates()[$index]['end_date']) : null;
    }

    function processDate($dateString) {
        $date = Carbon::createFromFormat('m/d/Y', $dateString)->format('d-m-Y');
        return $date;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getDepartureDatesAvailability(int $index):string|null{
        return array_key_exists("availability" , $this->getDepartureDates()[$index]) ? $this->getDepartureDates()[$index]['availability'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getDepartureDatesPrice(int $index):string|null{
        return array_key_exists("price" , $this->getDepartureDates()[$index]) ? $this->getDepartureDates()[$index]['price'] : null;
    }

    /**
     * @return array
     */
    public function getAccommodations(): array|null
    {
        return $this->accommodations;
    }

    /**
     * @return int|null
     */
    public function getAccommodationId(int $index):int|null{
        return array_key_exists("id" , $this->getAccommodations()[$index]) ? $this->getAccommodations()[$index]['id'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getAccommodationHotelName(int $index):string|null{
        return array_key_exists("hotel_name" , $this->getAccommodations()[$index]) ? $this->getAccommodations()[$index]['hotel_name'] : null;
    }

    /**
     * @param int $index
     * @return array|null
     */
    public function getAccommodationAmenity(int $index):array|null{
        return $this->getAccommodations()[$index]['amenities'];
    }


    /**
     * @param int $accommodationIndex
     * @param int $index
     * @return int|null
     */
    public function getAccommodationAmenityId(int $accommodationIndex , int $index):int|null{
        return array_key_exists("id" , $this->getAccommodationAmenity($accommodationIndex)[$index]) ? $this->getAccommodationAmenity($accommodationIndex)[$index]['id'] : null;
    }


    /**
     * @param int $accommodationIndex
     * @param int $index
     * @return string|null
     */
    public function getAccommodationAmenityMetaKey(int $accommodationIndex , int $index):string|null{
        return array_key_exists("meta_key" , $this->getAccommodationAmenity($accommodationIndex)[$index]) ? $this->getAccommodationAmenity($accommodationIndex)[$index]['meta_key'] : null;
    }

    /**
     * @param int $accommodationIndex
     * @param int $index
     * @return string|null
     */
    public function getAccommodationAmenityMetaValue(int $accommodationIndex , int $index):string|null{
        return array_key_exists("meta_value" , $this->getAccommodationAmenity($accommodationIndex)[$index]) ? $this->getAccommodationAmenity($accommodationIndex)[$index]['meta_value'] : null;
    }

    /**
     * @param int $accommodationIndex
     * @param int $index
     * @return string|null
     */
    public function getAccommodationAmenityIcon(int $accommodationIndex , int $index):string|null{
        return array_key_exists("icon" , $this->getAccommodationAmenity($accommodationIndex)[$index]) ? $this->getAccommodationAmenity($accommodationIndex)[$index]['icon'] : null;
    }

    /**
     * @return array|null
     */
    public function getLocations(): array|null
    {
        return $this->locations;
    }

    /**
     * @param int $index
     * @return int|null
     */
    public function getLocationsId(int $index):int|null{
        return array_key_exists("id" , $this->getLocations()[$index]) ? $this->getLocations()[$index]['id'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getLocationsLatitude(int $index):string|null{
        return array_key_exists("lat" , $this->getLocations()[$index]) ? $this->getLocations()[$index]['lat'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getLocationsLongitude(int $index):string|null{
        return array_key_exists("long" , $this->getLocations()[$index]) ? $this->getLocations()[$index]['long'] : null;
    }

    public function getLocationsMapImage(int $index):string|null{
        return array_key_exists("map_image" , $this->getLocations()[$index]) ? $this->getLocations()[$index]['map_image'] : null;
    }

    /**
     * @return array|null
     */
    public function getEssentialInfo(): array|null
    {
        return $this->essential_info;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getEssentialInfoId(int $index): int|null
    {
        return array_key_exists("id" , $this->getEssentialInfo()[$index]) ? $this->getEssentialInfo()[$index]['id'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getEssentialInfoTitle(int $index): string|null
    {
        return array_key_exists("title" , $this->getEssentialInfo()[$index]) ? $this->getEssentialInfo()[$index]['title'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getEssentialInfoDescription(int $index): string|null
    {
        return array_key_exists("description" , $this->getEssentialInfo()[$index]) ? $this->getEssentialInfo()[$index]['description'] : null;
    }

    public function getEssentialInfoPdf(int $index): UploadedFile|null
    {
        return !is_null($this->getEssentialInfoFiles())
            ? isset($this->getEssentialInfoFiles()[$index])
            ? array_key_exists("pdf" ,
                $this->getEssentialInfoFiles()[$index]
            )
                ? $this->getEssentialInfoFiles()[$index]['pdf']
                : null
            : null
            : null;
    }

    /**
     * @return array|null
     */
    public function getVideos(): array|null
    {
        return $this->videos;
    }

    /**
     * @param int $index
     * @return int|null
     */
    public function getVideoId(int $index): int|null
    {
        return array_key_exists("id" , $this->getVideos()[$index]) ? $this->getVideos()[$index]['id'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getVideoLink(int $index): string|null
    {
        return array_key_exists("video_link" , $this->getVideos()[$index]) ? $this->getVideos()[$index]['video_link'] : null;
    }

    /**
     * @return array|null
     */
    public function getGalleryFiles(): array|null
    {
        return $this->galleryFiles;
    }
    /**
     * @return array|null
     */
    public function getCabinDecks(): array|null
    {
        return $this->cabinDecks;
    }

    public function getCabinDeckId(int $index): int|null
    {
        return array_key_exists("id" , $this->getCabinDecks()[$index]) ? $this->getCabinDecks()[$index]['id'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getCabinDeckTitle(int $index): string|null
    {
        return array_key_exists("title" , $this->getCabinDecks()[$index]) ? $this->getCabinDecks()[$index]['title'] : null;
    }

    /**
     * @param int $index
     * @return string|null
     */
    public function getCabinDeckDescription(int $index): string|null
    {
        return array_key_exists("description" , $this->getCabinDecks()[$index]) ? $this->getCabinDecks()[$index]['description'] : null;
    }

    public function getCabinDeckPdf(int $index): UploadedFile|null
    {
        return
              !is_null($this->getCabinDeckFiles())
                    ? isset($this->getCabinDeckFiles()[$index])
                            ? array_key_exists("pdf" ,
                                $this->getCabinDeckFiles()[$index]
                            )
                            ? $this->getCabinDeckFiles()[$index]['pdf']
                            : null
                    : null
              : null;
    }

    /**
     * @return array|null
     */
    public function getCabinDeckFiles(): array|null
    {
        return $this->cabinDeckFiles;
    }

    /**
     * @return array|null
     */
    public function getEssentialInfoFiles(): array|null
    {
        return $this->essentialInfoFiles;
    }

    /**
     * @return array|null
     */
    public function getOrganizations(): ?array
    {
        return $this->organizations;
    }

    /**
     * @return array|null
     */
    public function getSliderFiles(): ?array
    {
        return $this->sliderFiles;
    }

    /**
     * @return string|null
     */
    public function getCountries(): array|null
    {
        return $this->countries;
    }

    /**
     * @return string|null
     */
    public function getApiSupplierId(): ?string
    {
        return $this->api_supplier_id;
    }

    /**
     * @return User
     */
    public function getObjAdmin(): User
    {
        return $this->objAdmin;
    }

    /**
     * @return string|null
     */
    public function getApiTourId(): ?string
    {
        return $this->api_tour_id;
    }

    /**
     * @return array|null
     */
    public function getImage(): string|null
    {
        return $this->image;
    }


}

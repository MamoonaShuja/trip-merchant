<?php

namespace Modules\Tour\Entities;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Modules\Core\Helpers\CloudinaryFileSystem\UploadFilesystem;
use Modules\Core\Traits\CustomMediaAlly;
use Modules\SupplierApi\Entities\ApiSupplier;
use Modules\SupplierApi\Entities\ApiTourId;
use Modules\Tour\Enum\CityTypes;
use Modules\Tour\Enum\MediaTypes;
use Modules\User\Entities\User;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use TourFactory;
use Modules\Core\Enum\Filesystem\Tour as TourPath;


/**
 * Modules\Tour\Entities\Tour
 *
 * @property string $id
 * @property string $tour_uuid
 * @property string $title
 * @property string $members_rate
 * @property string $discount_members_rate
 * @property string $members_benefit
 * @property string $total_days
 * @property string $total_nights
 * @property string $terms_and_conditions
 * @property string $overview
 * @property string $highlights
 * @property string $included
 * @property string $deposit_and_payments
 * @property string $not_included
 * @property string $total_meals
 * @property string $activity_level
 * @property string $passenger_limit
 * @property string $upgrades
 * @property string $age_range
 * @property boolean $is_visible
 * @property string $slug
 * @property string $health_and_safety
 * @property int $supplier_id
 * @property int $arrival_city_id
 * @property int $departure_city_id
 * @property int $country_id
 * @property int $travel_style_id
 * @property int $destination_id
 * @property int $api_supplier_id
 * @property int $api_tour_id
 * @method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination query()
 * @method whereSlug($value)
 * @method whereId($id)
 * @method whereTourUuid($id)
 * @method whereActivityLevel($val)
 * @method wherePassengerLimit($val)
 * @method whereIsVisible($val)
 * @method static Builder|TravelStyle whereCreatedAt($value)
 * @method static Builder|TravelStyle whereUpdatedAt($value)
 */
class Tour extends Model
{
    use HasFactory, HasSlug, SoftDeletes, CustomMediaAlly;

    protected $fillable = [];
    protected $guarded = [];

    protected $with = [
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
    ];

    /**
     * @return TourFactory
     */
    protected static function newFactory(): Factory
    {
        return TourFactory::new();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }

    /**
     * @return HasMany
     */
    public function accommodations()
    {
        return $this->hasMany(TourAccommodation::class, "tour_id");
    }

    /**
     * @return HasMany
     */
    public function departureDates()
    {
        return $this->hasMany(TourDepartureDate::class, "tour_id");
    }

    /**
     * @return HasMany
     */
    public function essentialInfos()
    {
        return $this->hasMany(TourEssentialInfo::class, "tour_id");
    }

    /**
     * @return HasMany
     */
    public function cabinDecks()
    {
        return $this->hasMany(TourCabinDeck::class, "tour_id");
    }

    /**
     * @return HasMany
     */
    public function faqs()
    {
        return $this->hasMany(TourFaq::class, "tour_id");
    }

    /**
     * @return HasMany
     */
    public function itinarary()
    {
        return $this->hasMany(TourItinerary::class, "tour_id");
    }

    /**
     * @return HasMany
     */
    public function locations()
    {
        return $this->hasMany(TourLocation::class, "tour_id");
    }

    /**
     * @return HasMany
     */
    public function reviews()
    {
        return $this->hasMany(TourReview::class, "tour_id");
    }

    /**
     * @return HasMany
     */
    public function videos()
    {
        return $this->hasMany(TourVideo::class, "tour_id");
    }

    /**
     * @return BelongsTo
     */
    public function travelStyle()
    {
        return $this->belongsTo(TravelStyle::class, "travel_style_id");
    }

    /**
     * @return BelongsToMany
     */
    public function arrivalCities()
    {
        return $this->belongsToMany(City::class, 'tour_city')->wherePivot("type", CityTypes::ARRIVAL_CITY->value);
    }

    /**
     * @return BelongsToMany
     */
    public function departureCities()
    {
        return $this->belongsToMany(City::class, 'tour_city')->wherePivot("type", CityTypes::DEPARTURE_CITY->value);
    }

    /**
     * @return BelongsToMany
     */
    public function destinations()
    {
        return $this->belongsToMany(Destination::class, "tour_destination");
    }

    /**
     * @return BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(User::class, "supplier_id");
    }


    public function quotes()
    {
        return $this->hasMany(TourQuote::class, "tour_id");
    }

    /**
     * @param UploadedFile $file
     * @return bool
     */
    public function setFeaturedImage(UploadedFile|string $file): bool
    {
        return UploadFilesystem::uploadImage($this, TourPath::FEATURED->value, MediaTypes::FEATURED->value, $file);
    }

    public function updateFeaturedImage(UploadedFile $file): bool
    {
        return UploadFilesystem::updateImage($this, TourPath::FEATURED->value, MediaTypes::FEATURED->value, $file);
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function setGallery(UploadedFile|string $file): bool
    {
        return UploadFilesystem::uploadImage($this, TourPath::GALLERY->value, MediaTypes::GALLERY->value, $file);
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function setSlider(UploadedFile|string $file): bool
    {
        return UploadFilesystem::uploadImage($this, TourPath::SLIDER->value, MediaTypes::SLIDER->value, $file);
    }

    /**
     * @param UploadedFile $file
     * @return bool
     */
    public function updateSlider(UploadedFile $file): bool
    {
        return UploadFilesystem::updateImage($this, TourPath::SLIDER->value, MediaTypes::SLIDER->value, $file);
    }

    /**
     * @param UploadedFile $file
     * @return bool
     */
    public function updateGallery(UploadedFile $file): bool
    {
        return UploadFilesystem::updateImage($this, TourPath::GALLERY->value, MediaTypes::GALLERY->value, $file);
    }

    /**rave
     * @return BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany(User::class, 'organization_tour', 'tour_id', 'organization_id');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, "tour_country");
    }

    /**
     * @return BelongsTo
     */
    public function apiSuppliers()
    {
        return $this->belongsTo(ApiSupplier::class, "api_supplier_id");
    }


    /**
     * @return BelongsTo
     */
    public function apiTourId()
    {
        return $this->belongsTo(ApiTourId::class, "api_tour_id");
    }

    public function scopeSearch($query, string|null $strTravelStyleId, string|null $strSupplierId, ?string $strDestinationId, ?string $strStartDate, ?string $strEndDate, ?string $strStartPrice, ?string $strEndPrice, ?string $strItineraryName)
    {

        $query->where('travel_style_id', $strTravelStyleId)
            ->when($strItineraryName, function ($query) use ($strItineraryName) {
                return $query->Where('title', 'like', '%' . $strItineraryName . '%');
            })
            ->when($strSupplierId, function ($query) use ($strSupplierId) {
                return $query->Where('supplier_id', $strSupplierId);
            })->when($strDestinationId, function ($query) use ($strDestinationId) {
                $query->whereHas('destinations', function ($query) use ($strDestinationId) {
                    return $query->where('destinations.id', $strDestinationId);
                });
            })->when($strStartDate, function ($query) use ($strStartDate) {
                $date = Carbon::createFromFormat('d-m-Y', $strStartDate);
                // format the date as a string in the format "Y-m-d"
                $strDate = $date->format('Y-m-d');
                return $query->whereHas('departureDates', function ($query) use ($strDate) {
                    return $query->where('start_date', '<=', $strDate);
                });
            })->when($strEndDate, function ($query) use ($strEndDate) {
                $date = Carbon::createFromFormat('d-m-Y', $strEndDate);
                // format the date as a string in the format "Y-m-d"
                $strDate = $date->format('Y-m-d');
                return $query->whereHas('departureDates', function ($query) use ($strDate) {
                    return $query->where('end_date', '>=', $strDate);
                });
            })->when($strStartPrice && $strEndPrice, function ($query) use ($strStartPrice, $strEndPrice) {
                return $query->whereBetween("members_rate", [$strStartPrice, $strEndPrice]);
            })->when($strStartPrice && !$strEndPrice, function ($query) use ($strStartPrice) {
                return $query->where("members_rate", ">=", $strStartPrice);
            })->when(!$strStartPrice && $strEndPrice, function ($query) use ($strEndPrice) {
                return $query->where("members_rate", "<=", $strEndPrice);
            });
    }

}

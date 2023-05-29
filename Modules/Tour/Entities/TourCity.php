<?php

namespace Modules\Tour\Entities;

use DestinationFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Helpers\Filesystem\DestinationFilesystem;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use TourCityFactory;

/**
 * Modules\User\Entities\TourCity
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination query()
 * @method static Builder|Destination whereName($value)
 * @method static Builder|TravelStyle whereCreatedAt($value)
 * @method static Builder|TravelStyle whereUpdatedAt($value)
 * @method static Builder|Destination whereSlug($value)
 * @method static Builder|Destination whereId($value)
 * @mixin Model
 */
class TourCity extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];

    /**
     * @return TourCityFactory
     */
    protected static function newFactory()
    {
        return TourCityFactory::new();
    }

    /**
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    /**
     * @return HasMany
     */
    public function arrivalTours(){
        return $this->hasMany(Tour::class , "arrival_city_id");
    }

    /**
     * @return HasMany
     */
    public function departureTours(){
        return $this->hasMany(Tour::class , "departure_city_id");
    }
}

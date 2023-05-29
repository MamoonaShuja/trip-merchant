<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tour\Database\factories\CityFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Modules\User\Entities\City
 *
 * @property string $id
 * @property string $name
 * @property string $city_uuid
 * @property string $country_id
 * @property string $slug
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City whereId($value)
 * @mixin Model
 */
class City extends Model
{
    use HasFactory, HasSlug , SoftDeletes;

    protected $guarded = [];
    protected $with=[
        "country"
    ];
    /**
     * @return CityFactory
     */
    protected static function newFactory()
    {
        return CityFactory::new();
    }

    /**
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    public function quotes(){
        return $this->hasMany(TourQuote::class , "city_id");
    }
    public function country(){
        return $this->belongsTo(Country::class , "country_id")->withTrashed();
    }
}

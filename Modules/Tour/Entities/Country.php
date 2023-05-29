<?php

namespace Modules\Tour\Entities;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tour\Database\factories\CountryFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Modules\User\Entities\City
 *
 * @property string $id
 * @property string $name
 * @property string $country_uuid
 * @property string $destination_id
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
class Country extends Model
{
    use HasFactory, HasSlug , SoftDeletes;

    protected $guarded = [];

    protected $with = [
    ];

    /**
     * @return CountryFactory
     */
    protected static function newFactory()
    {
        return CountryFactory::new();
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
    public function cities(){
        return $this->hasMany(City::class , "country_id");
    }

    public function destination(){
        return $this->belongsTo(Destination::class , "destination_id")->withTrashed();
    }
}

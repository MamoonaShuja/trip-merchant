<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TourAccommodationAmmenityFactory;
/**
 * Modules\Tour\Entities\TourAccommodationAmmenity
 *
 * @property string $id
 * @property string $meta_key
 * @property string $meta_value
 * @property string $icon
 * @property int $tour_accommodation_id
 * @method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination query()
 * @method whereMetaKey($value)
 * @method whereId($id)
 * @method whereMetaValue($val)
 * @method static Builder|TravelStyle whereCreatedAt($value)
 * @method static Builder|TravelStyle whereUpdatedAt($value)
 */

class TourAccommodationAmenity extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];

    protected static function newFactory()
    {
        return TourAccommodationAmmenityFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function accommodation(){
        return $this->belongsTo(TourAccommodation::class , "tour_accommodation_id");
    }

}

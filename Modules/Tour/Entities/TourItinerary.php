<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TourItineraryFactory;

/**
 * Modules\Tour\Entities\TourItinerary
 *
 * @property string $id
 * @property string $day
 * @property string $hotel_names
 * @property string $description
 * @property string $meals
 * @property string $optional
 * @property int $tour_id
 * @method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination query()
 * @method whereDay($value)
 * @method whereId($id)
 * @method whereMeals($val)
 * @method whereTourId($val)
 * @method static Builder|TravelStyle whereCreatedAt($value)
 * @method static Builder|TravelStyle whereUpdatedAt($value)
 */

class TourItinerary extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];
    /**
     * @return TourItineraryFactory
     */
    protected static function newFactory()
    {
        return TourItineraryFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function tour(){
        return $this->belongsTo(Tour::class , "tour_id");
    }

}

<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TourReviewFactory;
/**
 * Modules\Tour\Entities\TourAccommodation
 *
 * @property string $id
 * @property string $rating_accommodation
 * @property string $rating_overall
 * @property string $rating_meals
 * @property string $rating_transportation
 * @property string $name
 * @property string $email
 * @property string $comment
 * @property int $tour_id
 * @method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination query()
 * @method whereRatingAccommodation($value)
 * @method whereRatingOverall($value)
 * @method whereRatingMeals($value)
 * @method whereRatingTransportation($value)
 * @method whereRatingName($value)
 * @method whereEmail($value)
 * @method whereId($id)
 * @method whereTourId($val)
 * @method static Builder|TravelStyle whereCreatedAt($value)
 * @method static Builder|TravelStyle whereUpdatedAt($value)
 */
class TourReview extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];

    /**
     * @return TourReviewFactory
     */
    protected static function newFactory()
    {
        return TourReviewFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function tour(){
        return $this->belongsTo(Tour::class , "tour_id");
    }

}

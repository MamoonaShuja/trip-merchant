<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Entities\User;

/**
 * Modules\User\Entities\City
 *
 * @property string $id
 * @property string $passenger_number
 * @property string $tour_quote_uuid
 * @property string $date
 * @property string $description
 * @property boolean $status
 * @property string $note
 * @property string $user_id
 * @property string $city_id
 * @property string $tour_id
 * @method static Builder|TourQuote newModelQuery()
 * @method static Builder|TourQuote newQuery()
 * @method static Builder|TourQuote query()
 * @method static Builder|TourQuote whereCreatedAt($value)
 * @method static Builder|TourQuote whereUpdatedAt($value)
 * @method static Builder|TourQuote wherePassengerNumber($value)
 * @method static Builder|TourQuote whereTourQuoteUuid($value)
 * @method static Builder|TourQuote whereUserId($value)
 * @method static Builder|TourQuote whereCityId($value)
 * @method static Builder|TourQuote whereTourId($value)
 * @method static Builder|TourQuote whereId($value)
 * @mixin Model
 */
class TourQuote extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function tour(){
        return $this->belongsTo(Tour::class , "tour_id");
    }

    /**
     * @return BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class , "user_id");
    }

    /**
     * @return BelongsTo
     */
    public function city(){
        return $this->belongsTo(City::class , "city_id");
    }

}

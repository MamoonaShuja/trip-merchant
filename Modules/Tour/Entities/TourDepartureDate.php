<?php

namespace Modules\Tour\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TourDepartureDateFactory;
/**
 * Modules\Tour\Entities\TourDepartureDate
 *
 * @property string $id
 * @property string $year
 * @property string $start_date
 * @property string $end_date
 * @property string $availability
 * @property string $price
 * @property string $notes_link
 * @property string $optional_single_supplement
 * @property int $tour_id
 *@method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination query()
 * @method whereYear($value)
 * @method GroupBy($value)
 * @method whereId($id)
 * @method whereStartDate($val)
 * @method whereEndDate($val)
 * @method whereAvailability($val)
 * @method wherePrice($val)
 * @method whereTourId($val)
 * @method static Builder|TravelStyle whereCreatedAt($value)
 * @method static Builder|TravelStyle whereUpdatedAt($value)
 */

class TourDepartureDate extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];

    /**
     * @return TourDepartureDateFactory
     */
    protected static function newFactory()
    {
        return TourDepartureDateFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function tour(){
        return $this->belongsTo(Tour::class , "tour_id");
    }

    public function setStartDateAttribute($value){
        $this->attributes['start_date'] = Carbon::createFromFormat('d-m-Y', $value);
    }

    public function setEndDateAttribute($value){
        $this->attributes['end_date'] = Carbon::createFromFormat('d-m-Y', $value);
    }
}

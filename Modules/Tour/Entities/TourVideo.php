<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TourVideoFactory;

/**
 * Modules\Tour\Entities\TourAccommodation
 *
 * @property string $id
 * @property string $video_link
 * @property int $tour_id
 * @method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination query()
 * @method whereVideoLink($value)
 * @method whereId($id)
 * @method whereTourId($val)
 * @method static Builder|TravelStyle whereCreatedAt($value)
 * @method static Builder|TravelStyle whereUpdatedAt($value)
 */
class TourVideo extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];

    protected static function newFactory()
    {
        return TourVideoFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function tour(){
        return $this->belongsTo(Tour::class , "tour_id");
    }

}

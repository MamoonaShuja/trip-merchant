<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TourFaqFactory;
/**
 * Modules\Tour\Entities\TourFaq
 *
 * @property string $id
 * @property string $question
 * @property string $answer
 * @property int $tour_id
 * @method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination query()
 * @method whereQuestion($question)
 * @method whereAnswer($question)
 * @method whereId($id)
 * @method whereTourId($id)
 * @method whereCreatedAt($val)
 * @method whereUpdatedAt($val)
 */
class TourFaq extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];

    /**
     * @return TourFaqFactory
     */
    protected static function newFactory()
    {
        return TourFaqFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function tour(){
        return $this->belongsTo(Tour::class , "tour_id");
    }

}

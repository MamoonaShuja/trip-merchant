<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modules\User\Entities\Destination
 *
 * @property string $id
 * @property string $name
 * @property string $destination_uuid
 * @property string $slug
 * @property string $content
 * @property string $image
 * @method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination query()
 * @method static Builder|Destination whereCreatedAt($value)
 * @method static Builder|Destination whereUpdatedAt($value)
 * @method static Builder|Destination whereName($value)
 * @method static Builder|Destination whereId($value)
 * @method static Builder|Destination whereDestinationUuid($value)
 * @mixin Model
 */
class TourImageUrl extends Model
{
    use HasFactory  , SoftDeletes;

    protected $guarded = [];

    public function tour(){
        return $this->belongsTo(Tour::class , "tour_id");

    }

}

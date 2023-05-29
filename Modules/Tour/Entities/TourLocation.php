<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Helpers\CloudinaryFileSystem\UploadFilesystem;
use Modules\Core\Traits\CustomMediaAlly;
use Modules\Tour\Enum\MediaTypes;
use Modules\Core\Enum\Filesystem\Tour as TourPath;
use TourLocationFactory;

/**
 * Modules\Tour\Entities\TourLocation
 *
 * @property string $id
 * @property string $lat
 * @property string $long
 * @property int $tour_id
 * @property bool $is_image
 * @method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination query()
 * @method whereLat($value)
 * @method whereId($id)
 * @method whereLong($val)
 * @method whereTourId($val)
 * @method static Builder|TravelStyle whereCreatedAt($value)
 * @method static Builder|TravelStyle whereUpdatedAt($value)
 */
class TourLocation extends Model
{
    use HasFactory , CustomMediaAlly;

    protected $fillable = [];
    protected $guarded = [];

    /**
     * @return TourLocationFactory
     */
    protected static function newFactory(){
        return TourLocationFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function tour(){
        return $this->belongsTo(Tour::class , "tour_id");
    }

    /**
     * @return bool|string
     */
    public function saveImage(string $imageUrl):bool|string{
        return UploadFilesystem::uploadImage($this , TourPath::MAP->value ,  MediaTypes::MAP->value , $imageUrl);
    }

}

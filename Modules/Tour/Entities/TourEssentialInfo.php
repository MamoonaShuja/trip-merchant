<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use Modules\Core\Helpers\CloudinaryFileSystem\UploadFilesystem;
use Modules\Core\Traits\CustomMediaAlly;
use Modules\Tour\Enum\MediaTypes;
use Modules\Core\Enum\Filesystem\Tour as TourPaths;
use TourEssentialInfoFactory;
/**
 * Modules\Tour\Entities\TourEssentialInfo
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $tour_essential_info_uuid
 * @property int $tour_id
 *@method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination query()
 * @method whereTitle($value)
 * @method whereId($id)
 * @method whereTourEssentialInfoUuid($id)
 * @method whereTourId($val)
 * @method whereCreatedAt($val)
 * @method whereUpdatedAt($val)
 */

class TourEssentialInfo extends Model
{
    use HasFactory , CustomMediaAlly;

    protected $fillable = [];
    protected $guarded = [];
    protected $with = [
        'medially'
    ];
    /**
     * @return TourEssentialInfoFactory
     */
    protected static function newFactory()
    {
        return TourEssentialInfoFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function tour(){
        return $this->belongsTo(Tour::class , "tour_id");
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return void
     */
    public function savePdf(UploadedFile $uploadedFile){
        UploadFilesystem::uploadImage($this , TourPaths::ESSENTIAL_INFO->value , MediaTypes::ESSENTIAL_INFO->value , $uploadedFile);
    }
}

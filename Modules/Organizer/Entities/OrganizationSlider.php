<?php
namespace Modules\Organizer\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Modules\Core\Enum\Filesystem\Setting as SettingType;
use Modules\Core\Helpers\CloudinaryFileSystem\UploadFilesystem;
use Modules\Core\Traits\CustomMediaAlly;
use Modules\Tour\Enum\MediaTypes;

/**
 * Modules\User\Entities\Subscriber
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $organization_slider_uuid
 * @property \Modules\Organizer\Entities\Setting $setting
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class OrganizationSlider extends Model
{
    use HasFactory , CustomMediaAlly;

    protected $fillable = [];
    protected $guarded = [];

    protected $with = [
        'medially'
    ];
    public function saveSlider(UploadedFile $file){
        UploadFilesystem::uploadImage($this , SettingType::SLIDER->value , MediaTypes::SLIDER->value , $file);
    }

    public function sliders(){
        return $this->belongsTo(Setting::class , "setting_id");
    }

}


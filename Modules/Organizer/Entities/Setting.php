<?php
namespace Modules\Organizer\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Modules\Core\Enum\Filesystem\Setting as SettingType;
use Modules\Core\Helpers\CloudinaryFileSystem\UploadFilesystem;
use Modules\Core\Traits\CustomMediaAlly;
use Modules\Tour\Enum\MediaTypes;
use Modules\User\Entities\User;


/**
 * Modules\User\Entities\Subscriber
 *
 * @property int $id
 * @property string $meta_key
 * @property string $meta_value
 * @property string $organization_uuid
 * @property \Modules\User\Entities\User $organization
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Setting extends Model
{
    use HasFactory , CustomMediaAlly;

    protected $fillable = [];
    protected $guarded = [];

    protected static function newFactory(){
        return \Modules\User\Database\factories\SubscriberFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function organization(){
        return $this->belongsTo(User::class , "organization_id");
    }

    public function saveLogo(UploadedFile $file){
        UploadFilesystem::uploadImage($this , SettingType::LOGO->value , MediaTypes::LOGO->value , $file);
    }

    public function sliders(){
        return $this->hasMany(OrganizationSlider::class , "setting_id");
    }
}


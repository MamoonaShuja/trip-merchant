<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Enum\Filesystem\Destination as DestinationPath;
use Modules\Core\Helpers\CloudinaryFileSystem\UploadFilesystem;
use Modules\Core\Traits\CustomMediaAlly;
use Modules\Tour\Enum\MediaTypes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use TravelStyleFactory;
use Modules\Core\Enum\Filesystem\TravelStyle as TravelStylePath;

/**
 * Modules\User\Entities\User
 *
 * @property int $id
 * @property string $travel_styles_uuid
 * @property int $travel_style_uuid
 * @property string $name
 * @property string $content
 * @property string $image
 * @method static Builder|TravelStyle newModelQuery()
 * @method static Builder|TravelStyle newQuery()
 * @method static Builder|TravelStyle query()
 * @method static Builder|TravelStyle whereCreatedAt($value)
 * @method static Builder|TravelStyle whereUpdatedAt($value)
 * @method static Builder|TravelStyle whereName($value)
 * @method static Builder|TravelStyle whereId($value)
 * @method static Builder|TravelStyle whereTravelStyleUuid($value)
 * @mixin Model
 */
class TravelStyle extends Model
{
    use HasFactory, HasSlug , CustomMediaAlly , SoftDeletes;

    protected $guarded = [];
    /**
     * @var string[]
     */
    protected $hidden = ['id'];

    protected $with = [
        'medially'
    ];
    /**
     * @return TravelStyleFactory
     */
    protected static function newFactory()
    {
        return TravelStyleFactory::new();
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string
     */
    public function setImage(UploadedFile $uploadedFile): bool
    {
        return UploadFilesystem::uploadImage($this , TravelStylePath::IMAGE->value, MediaTypes::FEATURED->value, $uploadedFile);
    }


    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @return bool
     */
    public function setSlider(UploadedFile $file):bool {
        return UploadFilesystem::uploadImage($this ,DestinationPath::SLIDER->value , MediaTypes::SLIDER->value,  $file);
    }
    /**
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    /**
     * @return HasMany
     */
    public function tours(){
        return $this->hasMany(Tour::class , "travel_style_id");
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uid';
    }
}

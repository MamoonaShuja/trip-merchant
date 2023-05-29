<?php

namespace Modules\Tour\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Helpers\CloudinaryFileSystem\UploadFilesystem;
use Modules\Core\Traits\CustomMediaAlly;
use Modules\Tour\Database\factories\DestinationFactory;
use Modules\Tour\Enum\MediaTypes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Modules\Core\Enum\Filesystem\Destination as DestinationPath;

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
class Destination extends Model
{
    use HasFactory, HasSlug , CustomMediaAlly , SoftDeletes;

    protected $guarded = [];

    protected $with = [
        'medially',
        "countries"
    ];
    /**
     * @return DestinationFactory
     */
    protected static function newFactory()
    {
        return DestinationFactory::new();
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return bool
     */
    public function setImage(UploadedFile $uploadedFile): bool
    {
        return UploadFilesystem::uploadImage($this, DestinationPath::IMAGE->value , MediaTypes::FEATURED->value , $uploadedFile);
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
     * @return BelongsToMany
     */
    public function tours(){
        return $this->belongsToMany(Tour::class , "tour_destination");

    }

    public function countries(){
        return $this->hasMany(Country::class , "destination_id");
    }
}

<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Modules\Core\Entities\Permission;
use Modules\Core\Entities\Role;
use Modules\Core\Enum\Filesystem\User as UserPath;
use Modules\Core\Helpers\CloudinaryFileSystem\UploadFilesystem;
use Modules\Core\Services\Filesystem\FilesystemService;
use Modules\Core\Traits\CustomMediaAlly;
use Modules\Organizer\Entities\Setting;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourQuote;
use Modules\Tour\Enum\MediaTypes;
use Modules\User\Constants\UserFiles;
use Modules\User\Database\factories\UserFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


/**
 * Modules\User\Entities\User
 *
 * @property int $id
 * @property string $user_uuid
 * @property string $first_name
 * @property string $last_name
 * @property string $slug
 * @property string $email
 * @property string $contact
 * @property string $dob
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $bio
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $user_type
 * @property string $organization_name
 * @property string $website
 * @property string $message
 * @property string $domain
 * @property string $no_of_employees
 * @property float $code
 * @property float $organization_code
 * @property int $organization_id
 * @property boolean $is_approved
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereSlug($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereUserUuid($value)
 * @method static Builder|User whereUserType($value)
 * @method static Builder|User whereOrganizationName($value)
 * @method static Builder|User whereWebsite($value)
 * @method static Builder|User whereNoOfEmployees($value)
 * @method static Builder|User whereCode($value)
 * @method static Builder|User whereOrganizationCode($value)
 * @method static Builder|User whereDomain($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereUpdatedAt($value)

 */
class User extends Authenticatable
{
    use HasFactory , HasSlug , HasApiTokens , CustomMediaAlly , Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    protected $with = [
        'organization',
        'medially',
        "settings",
        "subscribers",
        "role",
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at'        => 'datetime',
    ];
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }


    /**
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('first_name')->saveSlugsTo('slug');
    }

    /**
     * @return string
     */
    public function getAvatarAttribute(): string
    {
        $objFilesystem = FilesystemService::factory();

        return $objFilesystem->url(sprintf(UserFiles::USER_AVATAR_FULL_NAME, $this->id));
    }

    /**
     * @return HasMany
     */
    public function members(){
        return $this->hasMany(User::class , "organization_id");
    }

    /**
     * @return BelongsTo
     */
    public function organization(){
        return $this->belongsTo(User::class , "organization_id");
    }

    /**
     * @return HasMany
     */
    public function subscribers(){
        return $this->hasMany(Subscriber::class , "organization_id");
    }

    public function settings(){
        return $this->hasMany(Setting::class , "organizer_id");
    }

    public function quotes(){
        return $this->hasMany(TourQuote::class , "user_id");
    }
    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'organization_tour', 'organization_id', 'tour_id');
    }

    public function role(){
        return $this->belongsTo(Role::class , "role_id");
    }

    public function uploadLogo(UploadedFile $file):bool{
        return UploadFilesystem::uploadImage($this , UserPath::LOGO->value, MediaTypes::LOGO->value, $file);
    }

}

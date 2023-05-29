<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;


/**
 * Modules\User\Entities\Subscriber
 *
 * @property int $id
 * @property string $subscribers_uuid
 * @property string $email
 * @property string $organization_uuid
 * @property User $organization
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereSubscribersUuid($value)
 * @method static Builder|User whereOrganizationId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereUpdatedAt($value)

 */
class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\SubscriberFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function organization(){
        return $this->belongsTo(User::class , "organization_id");
    }

}


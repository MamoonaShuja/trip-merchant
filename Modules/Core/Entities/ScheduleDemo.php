<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modules\Core\Entities\ScheduleDemo
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $type
 * @property string $demo_uuid
 * @property string $message
 * @method static Builder|ScheduleDemo newModelQuery()
 * @method static Builder|ScheduleDemo newQuery()
 * @method static Builder|ScheduleDemo query()
 * @method static Builder|ScheduleDemo whereCreatedAt($value)
 * @method static Builder|ScheduleDemo whereUpdatedAt($value)
 * @method static Builder|ScheduleDemo whereDemoUuid($value)
 * @mixin Model
 */
class ScheduleDemo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
//        return \Modules\Core\Database\factories\ScheduleDemo::new();
    }

}

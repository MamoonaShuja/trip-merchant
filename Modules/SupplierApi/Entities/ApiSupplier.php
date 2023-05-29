<?php
namespace Modules\SupplierApi\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Modules\Supplier\Entities\ApiSupplier
 *
 * @property int $id
 * @property string $name
 * @property string $main_url
 * @property string $single_record_url
 * @property string $is_authorization_needed
 * @property string $api_key
 * @property string $api_secret
 * @property string $unique_id_key
 * @property string $return_type
 * @property string $class_name
 * @property string $last_scrapped_at
 * @method static Builder|ApiSupplier newModelQuery()
 * @method static Builder|ApiSupplier newQuery()
 * @method static Builder|ApiSupplier query()
 * @method static Builder|ApiSupplier whereName($value)
 * @method static Builder|ApiSupplier whereMainUrl($value)
 * @method static Builder|ApiSupplier whereSingleRecordUrl($value)
 * @method static Builder|ApiSupplier whereIsAuthorizationNeeded($value)
 * @method static Builder|ApiSupplier whereApiKey($value)
 * @method static Builder|ApiSupplier whereApiSecret($value)
 * @method static Builder|ApiSupplier whereUniqueIdKey($value)
 * @method static Builder|ApiSupplier whereReturnType($value)
 * @method static Builder|ApiSupplier whereCreatedAt($value)
 * @method static Builder|ApiSupplier whereUpdatedAt($value)
 */
class ApiSupplier extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function tourIds(){
        return $this->hasMany(ApiTourId::class , "supplier_id");
    }

    public function nonFetchedTourIds(){
        return $this->hasMany(ApiTourId::class , "supplier_id")->whereFetched(0);
    }
}

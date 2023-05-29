<?php
namespace Modules\SupplierApi\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Supplier\Entities\ApiTourId
 *
 * @property int $id
 * @property string $unique_key
 * @property boolean $fetched
 * @property string $supplier_id
 * @property string $last_scrapped_at
 * @method static Builder|ApiTourId newModelQuery()
 * @method static Builder|ApiTourId newQuery()
 * @method static Builder|ApiTourId query()
 * @method static Builder|ApiTourId whereUniqueKey($value)
 * @method static Builder|ApiTourId whereSupplierId($value)
 * @method static Builder|ApiTourId whereFetched($value)
 * @method static Builder|ApiTourId whereCreatedAt($value)
 * @method static Builder|ApiTourId whereUpdatedAt($value)
 */
class ApiTourId extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function supplier(){
        return $this->belongsTo(ApiSupplier::class , "supplier_id");
    }
}

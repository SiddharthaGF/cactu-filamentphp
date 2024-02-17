<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Zone
 *
 * @property string $city_code
 * @property string $code
 * @property string $name
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property City $city
 * @property User $user
 * @property Collection|Community[] $communities
 * @property-read int|null $communities_count
 *
 * @method static Builder|Zone newModelQuery()
 * @method static Builder|Zone newQuery()
 * @method static Builder|Zone query()
 * @method static Builder|Zone whereCityCode($value)
 * @method static Builder|Zone whereCode($value)
 * @method static Builder|Zone whereCreatedAt($value)
 * @method static Builder|Zone whereCreatedBy($value)
 * @method static Builder|Zone whereName($value)
 * @method static Builder|Zone whereUpdatedAt($value)
 * @method static Builder|Zone whereUpdatedBy($value)
 *
 * @mixin IdeHelperZone
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @mixin Eloquent
 */
final class Zone extends Model
{
    use UserStamps;

    public $incrementing = false;

    public $primaryKey = 'code';
    /**
     * @var HigherOrderBuilderProxy|mixed
     */
    public mixed $mobile_numerable;

    protected $table = 'zones';

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'code',
        'city_code',
        'name',
        'created_by',
        'updated_by',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_code');
    }

    public function communities()
    {
        return $this->hasMany(Community::class, 'zone_code', 'code');
    }
}

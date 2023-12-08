<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
 * @method static \Illuminate\Database\Eloquent\Builder|Zone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone query()
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereUpdatedBy($value)
 *
 * @mixin IdeHelperZone
 *
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 *
 * @mixin \Eloquent
 */
final class Zone extends Model
{
    use UserStamps;

    public $incrementing = false;

    public $primaryKey = 'code';

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

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
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Zone whereUpdatedBy($value)
 *
 * @mixin IdeHelperZone
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @mixin \Eloquent
 */
final class MobileNumber extends Model
{
    use UserStamps;

    protected $table = 'mobile_numbers';

    protected $casts = [
        'mobile_numerable_id' => 'int',
        'mobile_numerable_type' => 'string',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'number',
        'created_by',
        'updated_by',
    ];

    public function mobile_numerable(): MorphTo
    {
        return $this->morphTo();
    }
}

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
 * Class Community
 *
 * @property int $id
 * @property string $name
 * @property string $zone_code
 * @property int $created_by
 * @property int $updated_by
 * @property string $vigency
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property Zone $zone
 * @property Collection|CommunityManager[] $community_managers
 * @package App\Models
 * @property-read int|null $community_managers_count
 * @method static \Illuminate\Database\Eloquent\Builder|Community newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Community newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Community query()
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereVigency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Community whereZoneCode($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCommunity
 */
final class Community extends Model
{

    use UserStamps;

    protected $table = 'communities';

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'name',
        'zone_code',
        'created_by',
        'updated_by',
        'vigency'
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_code', 'code');
    }

    public function community_managers()
    {
        return $this->hasMany(CommunityManagers::class);
    }
}

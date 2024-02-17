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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
 * @property-read int|null $community_managers_count
 *
 * @method static Builder|Community newModelQuery()
 * @method static Builder|Community newQuery()
 * @method static Builder|Community query()
 * @method static Builder|Community whereCreatedAt($value)
 * @method static Builder|Community whereCreatedBy($value)
 * @method static Builder|Community whereId($value)
 * @method static Builder|Community whereName($value)
 * @method static Builder|Community whereUpdatedAt($value)
 * @method static Builder|Community whereUpdatedBy($value)
 * @method static Builder|Community whereVigency($value)
 * @method static Builder|Community whereZoneCode($value)
 *
 * @mixin IdeHelperCommunity
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @mixin Eloquent
 */
final class Community extends Model
{
    use UserStamps;

    protected $table = 'communities';

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'name',
        'zone_code',
        'created_by',
        'updated_by',
        'vigency',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'zone_code', 'code');
    }

    public function community_managers(): HasMany
    {
        return $this->hasMany(CommunityManagers::class);
    }

    public function managers()
    {
        return $this->belongsToMany(User::class, 'community_managers', 'community_id', 'manager_id', 'manager_id', 'id');
    }
}

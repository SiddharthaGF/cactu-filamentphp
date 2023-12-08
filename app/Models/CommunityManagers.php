<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommunityManager
 *
 * @property int $id
 * @property int $manager_id
 * @property int $community_id
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Community $community
 * @property User $user
 * @property-read \App\Models\User $manager
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityManager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityManager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityManager query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityManager whereCommunityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityManager whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityManager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityManager whereManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityManager whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommunityManager whereUpdatedBy($value)
 *
 * @mixin IdeHelperCommunityManager
 *
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 *
 * @method static \Database\Factories\CommunityManagersFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
final class CommunityManagers extends Model
{
    use HasFactory;
    use UserStamps;

    protected $table = 'community_managers';

    protected $casts = [
        'manager_id' => 'int',
        'community_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'manager_id',
        'community_id',
        'created_by',
        'updated_by',
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }
}

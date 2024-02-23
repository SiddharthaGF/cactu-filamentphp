<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
 * @property int $vigency
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Zone $zone
 * @property Collection|CommunityManager[] $community_managers
 *
<<<<<<< HEAD
 * @package App\Models
=======
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
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
 */
class Community extends Model
{
	protected $table = 'communities';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int',
		'vigency' => 'int'
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
		return $this->belongsTo(Zone::class, 'zone_code');
	}

<<<<<<< HEAD
	public function community_managers()
	{
		return $this->hasMany(CommunityManager::class);
	}
=======
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
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
 * @property int $vigency
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Zone $zone
 * @property Collection|CommunityManager[] $community_managers
 *
 * @package App\Models
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

	public function community_managers()
	{
		return $this->hasMany(CommunityManager::class);
	}
}

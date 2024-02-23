<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommunityManager
 * 
 * @property int $id
 * @property int $community_id
 * @property int $manager_id
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Community $community
 * @property User $user
 *
 * @package App\Models
 */
class CommunityManager extends Model
{
	protected $table = 'community_managers';

	protected $casts = [
		'community_id' => 'int',
		'manager_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'community_id',
		'manager_id',
		'created_by',
		'updated_by'
	];

	public function community()
	{
		return $this->belongsTo(Community::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'manager_id');
	}
}

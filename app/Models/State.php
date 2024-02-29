<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class State
 *
 * @property string $code
 * @property string $name
 * @property int|null $coordinator_id
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|City[] $cities
 *
 * @package App\Models
 */
class State extends Model
{
	protected $table = 'states';
	protected $primaryKey = 'code';
	public $incrementing = false;

	protected $casts = [
		'coordinator_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'coordinator_id',
		'created_by',
		'updated_by'
	];

	public function coordinator(): BelongsTo
    {
		return $this->belongsTo(User::class, 'coordinator_id');
	}

	public function cities(): HasMany
    {
		return $this->hasMany(City::class, 'state_code');
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class City
 *
 * @property string $state_code
 * @property string $code
 * @property string $name
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property State $state
 * @property Collection|Zone[] $zones
 *
 * @package App\Models
 */
class City extends Model
{

    use UserStamps;

	protected $table = 'cities';
	protected $primaryKey = 'code';
	public $incrementing = false;

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'state_code',
		'name',
		'created_by',
		'updated_by'
	];

	public function state()
	{
		return $this->belongsTo(State::class, 'state_code');
	}

	public function zones()
	{
		return $this->hasMany(Zone::class, 'city_code');
	}
}

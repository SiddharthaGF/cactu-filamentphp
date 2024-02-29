<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RisksNearHome
 *
 * @property int $id
 * @property int $house_id
 * @property string $description
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property House $house
 *
 * @package App\Models
 */
class RisksNearHome extends Model
{

    use UserStamps;

	protected $table = 'risks_near_home';

	protected $casts = [
		'house_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'house_id',
		'description',
		'created_by',
		'updated_by'
	];

	public function house()
	{
		return $this->belongsTo(House::class);
	}
}

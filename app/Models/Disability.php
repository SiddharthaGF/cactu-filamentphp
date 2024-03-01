<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Disability
 *
 * @property int $id
 * @property int $child_id
 * @property int $type
 * @property int $percent
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Child $child
 *
 * @package App\Models
 */
class Disability extends Model
{

    use UserStamps;

	protected $table = 'disabilities';

	protected $casts = [
		'child_id' => 'int',
		'type' => 'int',
		'percent' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'child_id',
		'type',
		'percent',
		'created_by',
		'updated_by'
	];

	public function child()
	{
		return $this->belongsTo(Child::class);
	}
}

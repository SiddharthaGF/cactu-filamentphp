<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReasonsLeavingStudy
 * 
 * @property int $id
 * @property int $child_id
 * @property string $reason
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Child $child
 *
 * @package App\Models
 */
class ReasonsLeavingStudy extends Model
{
	protected $table = 'reasons_leaving_study';

	protected $casts = [
		'child_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'child_id',
		'reason',
		'created_by',
		'updated_by'
	];

	public function child()
	{
		return $this->belongsTo(Child::class);
	}
}

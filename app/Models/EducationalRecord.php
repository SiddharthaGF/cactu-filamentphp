<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EducationalRecord
 *
 * @property int $id
 * @property int $child_id
 * @property int $educational_institution_id
 * @property int $status
 * @property string $level
 * @property string $fovorite_subject
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Child $child
 * @property EducationalInstitution $educational_institution
 *
 * @package App\Models
 */
class EducationalRecord extends Model
{

    use UserStamps;

	protected $table = 'educational_record';

	protected $casts = [
		'child_id' => 'int',
		'educational_institution_id' => 'int',
		'status' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'child_id',
		'educational_institution_id',
		'status',
		'level',
		'fovorite_subject',
		'created_by',
		'updated_by'
	];

	public function child()
	{
		return $this->belongsTo(Child::class);
	}

	public function educational_institution()
	{
		return $this->belongsTo(EducationalInstitution::class);
	}
}

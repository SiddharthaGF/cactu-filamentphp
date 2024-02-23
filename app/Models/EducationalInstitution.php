<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EducationalInstitution
 * 
 * @property int $id
 * @property string $name
 * @property string|null $education_type
 * @property string|null $financing_type
 * @property string $zone_code
 * @property string|null $address
 * @property string|null $area
 * @property string|null $academic_regime
 * @property string|null $modality
 * @property string|null $academic_day
 * @property string|null $educative_level
 * @property string|null $typology
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|EducationalRecord[] $educational_records
 *
 * @package App\Models
 */
class EducationalInstitution extends Model
{
	protected $table = 'educational_institutions';

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'education_type',
		'financing_type',
		'zone_code',
		'address',
		'area',
		'academic_regime',
		'modality',
		'academic_day',
		'educative_level',
		'typology',
		'created_by',
		'updated_by'
	];

	public function educational_records()
	{
		return $this->hasMany(EducationalRecord::class);
	}
}

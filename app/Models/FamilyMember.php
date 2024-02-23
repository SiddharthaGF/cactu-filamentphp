<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FamilyMember
 * 
 * @property int $id
 * @property int $family_nucleus_id
 * @property string $name
 * @property Carbon $birthdate
 * @property int $gender
 * @property int $relationship
 * @property int $education_level
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property FamilyNucleus $family_nucleus
 *
 * @package App\Models
 */
class FamilyMember extends Model
{
	protected $table = 'family_members';

	protected $casts = [
		'family_nucleus_id' => 'int',
		'birthdate' => 'datetime',
		'gender' => 'int',
		'relationship' => 'int',
		'education_level' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'family_nucleus_id',
		'name',
		'birthdate',
		'gender',
		'relationship',
		'education_level',
		'created_by',
		'updated_by'
	];

	public function family_nucleus()
	{
		return $this->belongsTo(FamilyNucleus::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 * 
 * @property string $id
 * @property int $alliance_id
 * @property string $name
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Alliance $alliance
 * @property Collection|Child[] $children
 *
 * @package App\Models
 */
class Contact extends Model
{
	protected $table = 'contacts';
	public $incrementing = false;

	protected $casts = [
		'alliance_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'alliance_id',
		'name',
		'created_by',
		'updated_by'
	];

	public function alliance()
	{
		return $this->belongsTo(Alliance::class);
	}

	public function children()
	{
		return $this->hasMany(Child::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Zone
 * 
 * @property string $city_code
 * @property string $code
 * @property string $name
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property City $city
 * @property Collection|Community[] $communities
 *
<<<<<<< HEAD
 * @package App\Models
=======
 * @method static Builder|Zone newModelQuery()
 * @method static Builder|Zone newQuery()
 * @method static Builder|Zone query()
 * @method static Builder|Zone whereCityCode($value)
 * @method static Builder|Zone whereCode($value)
 * @method static Builder|Zone whereCreatedAt($value)
 * @method static Builder|Zone whereCreatedBy($value)
 * @method static Builder|Zone whereName($value)
 * @method static Builder|Zone whereUpdatedAt($value)
 * @method static Builder|Zone whereUpdatedBy($value)
 *
 * @mixin IdeHelperZone
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @mixin Eloquent
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
 */
class Zone extends Model
{
	protected $table = 'zones';
	protected $primaryKey = 'code';
	public $incrementing = false;

	protected $casts = [
		'created_by' => 'int',
		'updated_by' => 'int'
	];

<<<<<<< HEAD
	protected $fillable = [
		'city_code',
		'name',
		'created_by',
		'updated_by'
	];
=======
    public $primaryKey = 'code';
    /**
     * @var HigherOrderBuilderProxy|mixed
     */
    public mixed $mobile_numerable;
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8

	public function city()
	{
		return $this->belongsTo(City::class, 'city_code');
	}

	public function communities()
	{
		return $this->hasMany(Community::class, 'zone_code');
	}
}

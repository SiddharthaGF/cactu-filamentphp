<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
 * @property City $city
 * @property Collection|Community[] $communities
 * @property Collection|EducationalInstitution[] $educational_institutions
 */
class Zone extends Model
{
    use UserStamps;

    protected $table = 'zones';

    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'city_code',
        'name',
        'created_by',
        'updated_by',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_code');
    }

    public function communities()
    {
        return $this->hasMany(Community::class, 'zone_code');
    }

    public function educational_institutions()
    {
        return $this->hasMany(EducationalInstitution::class, 'zone_code');
    }
}

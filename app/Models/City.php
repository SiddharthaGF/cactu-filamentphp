<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
 * @property User $user
 * @property State $state
 * @property Collection|EducationalInstitution[] $educational_institutions
 * @property Collection|Zone[] $zones
 * @property-read int|null $educational_institutions_count
 * @property-read int|null $zones_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereStateCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedBy($value)
 *
 * @mixin IdeHelperCity
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @mixin \Eloquent
 */
final class City extends Model
{
    use UserStamps;

    public $incrementing = false;

    protected $table = 'cities';

    protected $primaryKey = 'code';

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'code',
        'state_code',
        'name',
        'created_by',
        'updated_by',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_code');
    }

    public function educational_institutions()
    {
        return $this->hasMany(EducationalInstitution::class, 'city_code');
    }

    public function zones()
    {
        return $this->hasMany(Zone::class, 'city_code');
    }
}

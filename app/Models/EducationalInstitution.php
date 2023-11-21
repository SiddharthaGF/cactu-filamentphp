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
 * Class EducationalInstitution
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $ideology
 * @property string $city_code
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property City $city
 * @property User $user
 * @property Collection|EducationalRecord[] $educational_records
 * @package App\Models
 * @property-read int|null $educational_records_count
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution query()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereIdeology($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereUpdatedBy($value)
 * @mixin \Eloquent
 * @mixin IdeHelperEducationalInstitution
 */
final class EducationalInstitution extends Model
{
    use UserStamps;

    protected $table = 'educational_institutions';

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'name',
        'type',
        'ideology',
        'city_code',
        'created_by',
        'updated_by'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_code');
    }

    public function educational_records()
    {
        return $this->hasMany(EducationalRecord::class);
    }
}

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
 * @property-read int|null $educational_records_count
 *
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
 *
 * @mixin IdeHelperEducationalInstitution
 *
 * @property string $education_type
 * @property string $financing_type
 * @property string $zone_code
 * @property string|null $address
 * @property string $area
 * @property string $academic_regime
 * @property string $modality
 * @property string $academic_day
 * @property string $educative_level
 * @property string $typology
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 * @property-read \App\Models\Zone $zone
 *
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereAcademicDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereAcademicRegime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereEducationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereEducativeLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereFinancingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereModality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereTypology($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalInstitution whereZoneCode($value)
 *
 * @mixin \Eloquent
 */
final class EducationalInstitution extends Model
{
    use UserStamps;

    protected $table = 'educational_institutions';

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'name',
        'education_type',
        'financing_type',
        'address',
        'area',
        'academic_regime',
        'ideology',
        'modality',
        'academic_day',
        'zone_code',
        'educative_level',
        'typology',
        'created_by',
        'updated_by',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_code');
    }

    public function educational_records()
    {
        return $this->hasMany(EducationalRecord::class);
    }
}

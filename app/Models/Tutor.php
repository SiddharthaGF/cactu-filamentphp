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
 * Class Tutor
 *
 * @property int $id
 * @property string $name
 * @property string $dni
 * @property string $gender
 * @property string|null $mobile_phone
 * @property Carbon $birthdate
 * @property bool $is_parent
 * @property bool $is_present
 * @property string|null $reason_not_present
 * @property string|null $specific_reason
 * @property Carbon|null $deathdate
 * @property string $occupation
 * @property string|null $specific_occupation
 * @property float $salary
 * @property Collection|FamilyNucleus[] $family_nuclei
 * @package App\Models
 * @property-read int|null $family_nuclei_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereDeathdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereIsParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereIsPresent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereMobilePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereReasonNotPresent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereSpecificOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereSpecificReason($value)
 * @mixin \Eloquent
 * @mixin IdeHelperTutor
 */
final class Tutor extends Model
{
    use UserStamps;

    public $timestamps = false;
    protected $table = 'tutors';

    protected $casts = [
        'birthdate' => 'datetime',
        'is_parent' => 'bool',
        'is_present' => 'bool',
        'deathdate' => 'datetime',
        'salary' => 'float'
    ];

    protected $fillable = [
        'name',
        'dni',
        'gender',
        'mobile_phone',
        'birthdate',
        'is_parent',
        'is_present',
        'reason_not_present',
        'specific_reason',
        'deathdate',
        'occupation',
        'specific_occupation',
        'salary'
    ];

    public function family_nuclei()
    {
        return $this->hasMany(FamilyNucleus::class, 'tutor2_id');
    }
}

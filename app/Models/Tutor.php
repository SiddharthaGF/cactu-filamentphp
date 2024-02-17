<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\FamilyRelationship;
use App\Enums\Gender;
use App\Enums\ReasonsIsNotPresent;
use App\Traits\UserStamps;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
 * @property-read int|null $family_nuclei_count
 *
 * @method static Builder|Tutor newModelQuery()
 * @method static Builder|Tutor newQuery()
 * @method static Builder|Tutor query()
 * @method static Builder|Tutor whereBirthdate($value)
 * @method static Builder|Tutor whereDeathdate($value)
 * @method static Builder|Tutor whereDni($value)
 * @method static Builder|Tutor whereGender($value)
 * @method static Builder|Tutor whereId($value)
 * @method static Builder|Tutor whereIsParent($value)
 * @method static Builder|Tutor whereIsPresent($value)
 * @method static Builder|Tutor whereMobilePhone($value)
 * @method static Builder|Tutor whereName($value)
 * @method static Builder|Tutor whereOccupation($value)
 * @method static Builder|Tutor whereReasonNotPresent($value)
 * @method static Builder|Tutor whereSalary($value)
 * @method static Builder|Tutor whereSpecificOccupation($value)
 * @method static Builder|Tutor whereSpecificReason($value)
 *
 * @property int $created_by
 * @property int $updated_by
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read User|null $creator
 * @property-read Collection<int, FamilyNucleus> $family_nuclei_1
 * @property-read int|null $family_nuclei_1_count
 * @property-read Collection<int, FamilyNucleus> $family_nuclei_2
 * @property-read int|null $family_nuclei_2_count
 * @property-read User|null $updater
 *
 * @method static Builder|Tutor whereCreatedAt($value)
 * @method static Builder|Tutor whereCreatedBy($value)
 * @method static Builder|Tutor whereUpdatedAt($value)
 * @method static Builder|Tutor whereUpdatedBy($value)
 *
 * @mixin Eloquent
 */
final class Tutor extends Model
{
    use UserStamps;

    protected $table = 'tutors';

    protected $casts = [
        'birthdate' => 'datetime',
        'relationship' => FamilyRelationship::class,
        'is_present' => 'bool',
        'deathdate' => 'datetime',
        'salary' => 'float',
        'gender' => Gender::class,
        'reason_not_present' => ReasonsIsNotPresent::class,
    ];

    protected $fillable = [
        'family_nucleus_id',
        'name',
        'dni',
        'gender',
        'birthdate',
        'relationship',
        'is_present',
        'reason_not_present',
        'specific_reason',
        'deathdate',
        'occupation',
        'specific_occupation',
        'salary',
    ];

    public function family_nucleus(): BelongsTo
    {
        return $this->belongsTo(FamilyNucleus::class);
    }

    public function mobile_number(): MorphOne
    {
        return $this->morphOne(MobileNumber::class, 'mobile_numerable');
    }

}

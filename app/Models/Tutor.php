<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\FamilyRelationship;
use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class Tutor
 *
 * @property int $id
 * @property int $family_nucleus_id
 * @property string $name
 * @property string $dni
 * @property int $gender
 * @property Carbon $birthdate
 * @property int $relationship
 * @property bool $is_present
 * @property int|null $reason_not_present
 * @property string|null $specific_reason
 * @property Carbon|null $deathdate
 * @property int|null $occupation
 * @property string|null $specific_occupation
 * @property float|null $salary
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property FamilyNucleus $family_nucleus
 */
class Tutor extends Model
{
    use UserStamps;

    protected $table = 'tutors';

    protected $casts = [
        'family_nucleus_id' => 'int',
        'gender' => 'int',
        'birthdate' => 'datetime',
        'relationship' => FamilyRelationship::class,
        'is_present' => 'bool',
        'reason_not_present' => 'int',
        'deathdate' => 'datetime',
        'occupation' => 'int',
        'salary' => 'float',
        'created_by' => 'int',
        'updated_by' => 'int',
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
        'created_by',
        'updated_by',
    ];

    public function family_nucleus()
    {
        return $this->belongsTo(FamilyNucleus::class);
    }

    public function mobile_number(): MorphOne
    {
        return $this->morphOne(MobileNumber::class, 'mobile_numerable');
    }
}

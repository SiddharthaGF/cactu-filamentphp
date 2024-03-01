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
 * Class FamilyNucleus
 *
 * @property int $id
 * @property string|null $conventional_phone
 * @property array|null $risk_factors
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Child[] $children
 * @property Collection|FamilyMember[] $family_members
 * @property Collection|House[] $houses
 * @property Collection|Tutor[] $tutors
 *
 * @package App\Models
 */
class FamilyNucleus extends Model
{

    use UserStamps;

    protected $table = 'family_nuclei';

    protected $casts = [
        'risk_factors' => 'json',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'conventional_phone',
        'risk_factors',
        'created_by',
        'updated_by'
    ];

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function family_members()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function house()
    {
        return $this->hasOne(House::class);
    }

    public function tutors()
    {
        return $this->hasMany(Tutor::class);
    }

    public function banking_information()
    {
        return $this->morphOne(BankingInformation::class, 'banking_informationable');
    }
}

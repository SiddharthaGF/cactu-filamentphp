<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\RisksTutor;
use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class FamilyNucleus
 *
 * @property int $id
 * @property int|null $tutor1_id
 * @property int|null $tutor2_id
 * @property string|null $conventional_phone
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property Tutor|null $tutor
 * @property Collection|BankingInformation[] $banking_informations
 * @property Collection|Child[] $children
 * @property Collection|FamilyMember[] $family_members
 * @property Collection|House[] $houses
 * @property-read int|null $banking_informations_count
 * @property-read int|null $children_count
 * @property-read int|null $family_members_count
 * @property-read int|null $houses_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyNucleus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyNucleus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyNucleus query()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyNucleus whereConventionalPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyNucleus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyNucleus whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyNucleus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyNucleus whereTutor1Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyNucleus whereTutor2Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyNucleus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyNucleus whereUpdatedBy($value)
 *
 * @mixin IdeHelperFamilyNucleus
 *
 * @property-read \App\Models\BankingInformation|null $banking_information
 * @property-read \App\Models\User|null $creator
 * @property-read string $name
 * @property-read \App\Models\House|null $house
 * @property-read \App\Models\Tutor|null $tutor_1
 * @property-read \App\Models\Tutor|null $tutor_2
 * @property-read \App\Models\User|null $updater
 *
 * @mixin \Eloquent
 */
final class FamilyNucleus extends Model
{
    use UserStamps;

    protected $table = 'family_nuclei';

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int',
        'risk_factors' => 'json',
    ];

    protected $fillable = [
        'conventional_phone',
        'risk_factors',
        'created_by',
        'updated_by',
    ];

    public function tutors(): HasMany
    {
        return $this->hasMany(Tutor::class);
    }

    public function banking_information(): MorphOne
    {
        return $this->morphOne(BankingInformation::class, 'banking_informationable');
    }

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
}

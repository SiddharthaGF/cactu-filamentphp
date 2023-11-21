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
 * @package App\Models
 * @property-read int|null $banking_informations_count
 * @property-read int|null $children_count
 * @property-read int|null $family_members_count
 * @property-read int|null $houses_count
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
 * @mixin \Eloquent
 * @mixin IdeHelperFamilyNucleus
 */
final class FamilyNucleus extends Model
{
    use UserStamps;

    protected $table = 'family_nuclei';

    protected $casts = [
        'tutor1_id' => 'int',
        'tutor2_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'tutor1_id',
        'tutor2_id',
        'conventional_phone',
        'created_by',
        'updated_by'
    ];

    public function tutor1()
    {
        return $this->belongsTo(Tutor::class, 'tutor1_id');
    }

    public function tutor2()
    {
        return $this->belongsTo(Tutor::class, 'tutor2_id');
    }


    public function banking_informations()
    {
        return $this->hasMany(BankingInformation::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function family_members()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function houses()
    {
        return $this->hasMany(House::class);
    }
}

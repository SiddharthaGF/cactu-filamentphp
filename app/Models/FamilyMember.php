<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\FamilyRelationship;
use App\Enums\Gender;
use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FamilyMember
 *
 * @property int $id
 * @property int $family_nucleus_id
 * @property string $name
 * @property Carbon $birthdate
 * @property string $gender
 * @property string $relationship
 * @property string $education_level
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property FamilyNucleus $family_nucleus
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereEducationLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereFamilyNucleusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyMember whereUpdatedBy($value)
 *
 * @mixin IdeHelperFamilyMember
 *
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 *
 * @mixin \Eloquent
 */
final class FamilyMember extends Model
{
    use UserStamps;

    protected $table = 'family_members';

    protected $casts = [
        'family_nucleus_id' => 'int',
        'birthdate' => 'datetime',
        'gender' => Gender::class,
        'relationship' => FamilyRelationship::class,
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'family_nucleus_id',
        'name',
        'birthdate',
        'gender',
        'relationship',
        'education_level',
        'created_by',
        'updated_by',
    ];

    public function family_nucleus()
    {
        return $this->belongsTo(FamilyNucleus::class);
    }
}

<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\HasManagerId;
use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Child
 *
 * @property int $id
 * @property string|null $children_number
 * @property string|null $case_number
 * @property int $family_nucleus_id
 * @property string|null $contact_id
 * @property string $name
 * @property string $dni
 * @property string $gender
 * @property Carbon $birthdate
 * @property string $affiliation_status
 * @property string $pseudonym
 * @property string $sexual_identity
 * @property string $literacy
 * @property string $language
 * @property string|null $specific_language
 * @property string|null $religious
 * @property string $nationality
 * @property string|null $specific_nationality
 * @property string $migratory_status
 * @property string $ethnic_group
 * @property array|null $activities_for_family_support
 * @property array|null $recreation_activities
 * @property array|null $additional_information
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $reviewed_by
 * @property Carbon|null $reviewed_at
 * @property int|null $disaffiliated_by
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $disaffiliated_at
 * @property Contact|null $contact
 * @property User $user
 * @property FamilyNucleus $family_nucleus
 * @property Collection|BankingInformation[] $banking_informations
 * @property Collection|EducationalRecord[] $educational_records
 * @property Collection|HealthStatusRecord[] $health_status_records
 * @property Mailbox $mailbox
 * @property Collection|PreschoolEducationalRecord[] $preschool_educational_records
 * @property ReasonsLeavingStudy $reasons_leaving_study
 * @package App\Models
 * @property-read int|null $banking_informations_count
 * @property-read int|null $educational_records_count
 * @property-read int|null $health_status_records_count
 * @property-read int|null $preschool_educational_records_count
 * @method static \Illuminate\Database\Eloquent\Builder|Child newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Child newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Child query()
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereActivitiesForFamilySupport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereAdditionalInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereAffiliationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereCaseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereChildrenNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereDisaffiliatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereDisaffiliatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereEthnicGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereFamilyNucleusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereLiteracy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereMigratoryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child wherePseudonym($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereRecreationActivities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereReligious($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereReviewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereReviewedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereSexualIdentity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereSpecificLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereSpecificNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereUpdatedBy($value)
 * @mixin \Eloquent
 * @mixin IdeHelperChild
 */
final class Child extends Model
{

    use UserStamps;
    use HasManagerId;

    protected $table = 'children';

    protected $casts = [
        'family_nucleus_id' => 'int',
        'birthdate' => 'datetime',
        'activities_for_family_support' => 'json',
        'recreation_activities' => 'json',
        'additional_information' => 'json',
        'reviewed_by' => 'int',
        'reviewed_at' => 'datetime',
        'disaffiliated_by' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'disaffiliated_at' => 'datetime'
    ];

    protected $fillable = [
        'children_number',
        'case_number',
        'family_nucleus_id',
        'contact_id',
        'name',
        'dni',
        'gender',
        'birthdate',
        'affiliation_status',
        'pseudonym',
        'sexual_identity',
        'literacy',
        'language',
        'specific_language',
        'religious',
        'nationality',
        'specific_nationality',
        'migratory_status',
        'ethnic_group',
        'activities_for_family_support',
        'recreation_activities',
        'additional_information',
        'reviewed_by',
        'reviewed_at',
        'disaffiliated_by',
        'created_by',
        'updated_by',
        'disaffiliated_at'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function family_nucleus()
    {
        return $this->belongsTo(FamilyNucleus::class);
    }

    public function banking_informations()
    {
        return $this->hasMany(BankingInformation::class);
    }

    public function educational_records()
    {
        return $this->hasMany(EducationalRecord::class);
    }

    public function health_status_records()
    {
        return $this->hasMany(HealthStatusRecord::class);
    }

    public function mailbox()
    {
        return $this->hasOne(Mailbox::class, 'id');
    }

    public function preschool_educational_records()
    {
        return $this->hasMany(PreschoolEducationalRecord::class);
    }

    public function reasons_leaving_study()
    {
        return $this->hasOne(ReasonsLeavingStudy::class);
    }
}

<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\AffiliationStatus;
use App\Enums\Gender;
use App\Enums\HealthStatus;
use App\Traits\HasRecords;
use App\Traits\UserStamps;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
 * @property-read int|null $banking_informations_count
 * @property-read int|null $educational_records_count
 * @property-read int|null $health_status_records_count
 * @property-read int|null $preschool_educational_records_count
 *
 * @method static Builder|Child newModelQuery()
 * @method static Builder|Child newQuery()
 * @method static Builder|Child query()
 * @method static Builder|Child whereActivitiesForFamilySupport($value)
 * @method static Builder|Child whereAdditionalInformation($value)
 * @method static Builder|Child whereAffiliationStatus($value)
 * @method static Builder|Child whereBirthdate($value)
 * @method static Builder|Child whereCaseNumber($value)
 * @method static Builder|Child whereChildrenNumber($value)
 * @method static Builder|Child whereContactId($value)
 * @method static Builder|Child whereCreatedAt($value)
 * @method static Builder|Child whereCreatedBy($value)
 * @method static Builder|Child whereDisaffiliatedAt($value)
 * @method static Builder|Child whereDisaffiliatedBy($value)
 * @method static Builder|Child whereDni($value)
 * @method static Builder|Child whereEthnicGroup($value)
 * @method static Builder|Child whereFamilyNucleusId($value)
 * @method static Builder|Child whereGender($value)
 * @method static Builder|Child whereId($value)
 * @method static Builder|Child whereLanguage($value)
 * @method static Builder|Child whereLiteracy($value)
 * @method static Builder|Child whereMigratoryStatus($value)
 * @method static Builder|Child whereName($value)
 * @method static Builder|Child whereNationality($value)
 * @method static Builder|Child wherePseudonym($value)
 * @method static Builder|Child whereRecreationActivities($value)
 * @method static Builder|Child whereReligious($value)
 * @method static Builder|Child whereReviewedAt($value)
 * @method static Builder|Child whereReviewedBy($value)
 * @method static Builder|Child whereSexualIdentity($value)
 * @method static Builder|Child whereSpecificLanguage($value)
 * @method static Builder|Child whereSpecificNationality($value)
 * @method static Builder|Child whereUpdatedAt($value)
 * @method static Builder|Child whereUpdatedBy($value)
 *
 * @mixin IdeHelperChild
 *
 * @property int $manager_id
 * @property-read BankingInformation|null $banking_information
 * @property-read User|null $creator
 * @property-read User $manager
 * @property-read User|null $updater
 *
 * @method static Builder|Child whereManagerId($value)
 *
 * @mixin Eloquent
 */
final class Child extends Model
{
    use HasRecords;
    use UserStamps;

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
        'disaffiliated_at' => 'datetime',
        'gender' => Gender::class,
        'affiliation_status' => AffiliationStatus::class,
        'health_status' => HealthStatus::class,
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
        'disaffiliated_at',
        'health_status'
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function family_nucleus(): BelongsTo
    {
        return $this->belongsTo(FamilyNucleus::class);
    }

    public function banking_information(): MorphOne
    {
        return $this->morphOne(BankingInformation::class, 'banking_informationable');
    }

    public function educational_record(): HasOne
    {
        return $this->hasOne(EducationalRecord::class);
    }

    public function health_status_record(): HasOne
    {
        return $this->hasOne(HealthStatusRecord::class);
    }

    public function mailbox(): HasOne
    {
        return $this->hasOne(Mailbox::class, 'id');
    }

    public function reasons_leaving_study(): HasOne
    {
        return $this->hasOne(ReasonsLeavingStudy::class);
    }

    public function mobile_number(): MorphOne
    {
        return $this->morphOne(MobileNumber::class, 'mobile_numerable');
    }
}

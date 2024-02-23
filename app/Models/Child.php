<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\AffiliationStatus;
use App\Enums\Gender;
use App\Enums\HealthStatus;
use App\Enums\Message;
<<<<<<< HEAD
use App\Enums\SexualIdentity;
use App\Enums\WhatsappCommands;
use App\Jobs\WhatsappJob;
use Carbon\Carbon;
use Filament\Models\Contracts\HasAvatar;
=======
use App\Enums\RisksChild;
use App\Enums\SexualIdentity;
use App\Enums\WhatsappCommands;
use App\Jobs\WhatsappJob;
use App\Traits\HasRecords;
use App\Traits\UserStamps;
use Carbon\Carbon;
use Eloquent;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Builder;
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\Button;
use Storage;

/**
 * Class Child
 *
 * @property int $id
 * @property int $manager_id
 * @property string|null $children_number
 * @property string|null $case_number
 * @property int|null $family_nucleus_id
 * @property string|null $contact_id
 * @property string $name
 * @property string $dni
 * @property int $gender
 * @property Carbon $birthdate
 * @property int $affiliation_status
 * @property string $pseudonym
 * @property int $sexual_identity
 * @property int $literacy
 * @property int $language
 * @property string|null $specific_language
 * @property string|null $religious
 * @property int $nationality
 * @property string|null $specific_nationality
 * @property int $migratory_status
 * @property int $ethnic_group
 * @property array|null $activities_for_family_support
 * @property array|null $recreation_activities
 * @property array|null $additional_information
 * @property int $health_status
 * @property int|null $reviewed_by
 * @property Carbon|null $reviewed_at
 * @property int|null $disaffiliated_by
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $disaffiliated_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $child_photo_path
 * @property array|null $risks_child
 * @property string $physical_description
 * @property string $aspirations
 * @property string $personality
 * @property string|null $skills
 * @property string|null $likes
 * @property string|null $dislikes
 * @property string|null $signature
 *
 * @property Contact|null $contact
 * @property User|null $user
 * @property FamilyNucleus|null $family_nucleus
 * @property Collection|Disability[] $disabilities
 * @property Collection|EducationalRecord[] $educational_records
 * @property Collection|HealthStatusRecord[] $health_status_records
 * @property Mailbox $mailbox
 * @property Collection|ReasonsLeavingStudy[] $reasons_leaving_studies
 *
 * @package App\Models
 */
<<<<<<< HEAD
class Child extends Model implements HasAvatar
=======
final class Child extends Model implements HasAvatar
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
{
    protected $table = 'children';

    protected $casts = [
        'manager_id' => 'int',
        'family_nucleus_id' => 'int',
        'gender' => Gender::class,
        'birthdate' => 'datetime',
        'affiliation_status' => AffiliationStatus::class,
        'sexual_identity' => SexualIdentity::class,
        'literacy' => 'int',
        'language' => 'int',
        'nationality' => 'int',
        'migratory_status' => 'int',
        'ethnic_group' => 'int',
        'activities_for_family_support' => 'json',
        'recreation_activities' => 'json',
        'additional_information' => 'json',
        'health_status' => HealthStatus::class,
        'reviewed_by' => 'int',
        'reviewed_at' => 'datetime',
        'disaffiliated_by' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'disaffiliated_at' => 'datetime',
<<<<<<< HEAD
        'risks_child' => 'json'
=======
        'gender' => Gender::class,
        'sexual_identity' => SexualIdentity::class,
        'affiliation_status' => AffiliationStatus::class,
        'health_status' => HealthStatus::class,
        'risks_child' => 'json',
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
    ];

    protected $fillable = [
        'manager_id',
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
        'health_status',
        'reviewed_by',
        'reviewed_at',
        'disaffiliated_by',
        'created_by',
        'updated_by',
        'disaffiliated_at',
<<<<<<< HEAD
        'child_photo_path',
        'risks_child',
=======
        'health_status',
        'child_photo_path',
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
        'physical_description',
        'aspirations',
        'personality',
        'skills',
        'likes',
        'dislikes',
<<<<<<< HEAD
        'signature'
    ];

    public function contact()
=======
        'risks_child',
        "signature",
        'manager_id'
    ];

    public function getFilamentAvatarUrl(): ?string
    {
        $url = $this->child_photo_path ? Storage::disk('public')->url($this->child_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
        return $url;
    }

    public function contact(): BelongsTo
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
    {
        return $this->belongsTo(Contact::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function family_nucleus()
    {
        return $this->belongsTo(FamilyNucleus::class);
    }

    public function disabilities()
    {
        return $this->hasMany(Disability::class);
    }

    public function educational_record()
    {
        return $this->hasOne(EducationalRecord::class);
    }

    public function health_status_record()
    {
        return $this->hasOne(HealthStatusRecord::class);
    }

    public function mailbox()
    {
        return $this->hasOne(Mailbox::class, 'id');
    }

    public function reasons_leaving_study()
    {
        return $this->hasOne(ReasonsLeavingStudy::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $url = $this->child_photo_path ? Storage::url($this->child_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
        return $url;
    }

    public function banking_information(): MorphOne
    {
        return $this->morphOne(BankingInformation::class, 'banking_informationable');
    }

    public function mobile_number(): MorphOne
    {
<<<<<<< HEAD
        return $this->morphOne(MobileNumber::class, 'mobile_numerable');
=======
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

    public function disabilities(): HasMany
    {
        return $this->hasMany(Disability::class, 'child_id');
    }

    public function NotifyMails(int $id): void
    {
        $mobile_number = $this->getMobileNumber();
        $pseudonym = $this->pseudonym;
        if ($this->hasMobileNumber()) {
            $text = str_replace("%pseudonym%", $pseudonym, Message::HelloForChild->value);
        } else {
            $tutor_name = $this->family_nucleus->tutors()->first()->name;
            $text = str_replace('%tutor%', $tutor_name, str_replace("%pseudonym%", $pseudonym, Message::HelloForTutor->value));
        }
        WhatsappJob::sendButtonReplyMessage($mobile_number, $text, [new Button(WhatsappCommands::ViewNow->value . ' ' . $id, WhatsappCommands::ViewNow->getLabel())]);
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobile_number->number ?? $this->family_nucleus->tutors()->with('mobile_number')->first()->mobile_number->number ?? null;
    }

    public function hasMobileNumber(): bool
    {
        return $this->mobile_number()->exists();
    }

    public function NotifyMails(int $id): void
    {
        $mobile_number = $this->getMobileNumber();
        $pseudonym = $this->pseudonym;
        if ($this->hasMobileNumber()) {
            $text = str_replace("%pseudonym%", $pseudonym, Message::HelloForChild->value);
        } else {
            $tutor_name = $this->family_nucleus->tutors()->first()->name;
            $text = str_replace('%tutor%', $tutor_name, str_replace("%pseudonym%", $pseudonym, Message::HelloForTutor->value));
        }
        WhatsappJob::sendButtonReplyMessage($mobile_number, $text, [new Button(WhatsappCommands::ViewNow->value . ' ' . $id, WhatsappCommands::ViewNow->getLabel())]);
    }

    public function isOnlyAffiliated(): bool
    {
        return 1 === $this->family_nucleus->children()->count();
    }
}

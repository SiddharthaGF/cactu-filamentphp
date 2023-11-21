<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $local_partner_id
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property string|null $profile_photo_path
 * @property string|null $signature_photo_path
 * @property string|null $md5_signature_photo
 * @property string $vigency
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property LocalPartner $local_partner
 * @property Collection|Alliance[] $alliances
 * @property Collection|BankingInformation[] $banking_informations
 * @property Collection|Child[] $children
 * @property Collection|City[] $cities
 * @property Collection|Community[] $communities
 * @property Collection|CommunityManager[] $community_managers
 * @property CommunityManager $community_manager
 * @property Collection|Contact[] $contacts
 * @property Collection|EducationalInstitution[] $educational_institutions
 * @property Collection|EducationalRecord[] $educational_records
 * @property Collection|FamilyMember[] $family_members
 * @property Collection|FamilyNucleus[] $family_nuclei
 * @property Collection|HealthStatusRecord[] $health_status_records
 * @property Collection|House[] $houses
 * @property Collection|Letter[] $letters
 * @property Collection|LocalPartner[] $local_partners
 * @property Collection|Mailbox[] $mailboxes
 * @property Collection|PreschoolEducationalRecord[] $preschool_educational_records
 * @property Collection|ReasonsLeavingStudy[] $reasons_leaving_studies
 * @property Collection|State[] $states
 * @property Collection|Ticket[] $tickets
 * @property Collection|User[] $users
 * @property Collection|Zone[] $zones
 * @package App\Models
 * @property-read int|null $alliances_count
 * @property-read int|null $banking_informations_count
 * @property-read int|null $children_count
 * @property-read int|null $cities_count
 * @property-read int|null $communities_count
 * @property-read int|null $community_managers_count
 * @property-read int|null $contacts_count
 * @property-read int|null $educational_institutions_count
 * @property-read int|null $educational_records_count
 * @property-read int|null $family_members_count
 * @property-read int|null $family_nuclei_count
 * @property-read int|null $health_status_records_count
 * @property-read int|null $houses_count
 * @property-read int|null $letters_count
 * @property-read int|null $local_partners_count
 * @property-read int|null $mailboxes_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read int|null $preschool_educational_records_count
 * @property-read int|null $reasons_leaving_studies_count
 * @property-read Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read int|null $states_count
 * @property-read int|null $tickets_count
 * @property-read Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read int|null $users_count
 * @property-read int|null $zones_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLocalPartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMd5SignaturePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSignaturePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVigency($value)
 * @mixin \Eloquent
 * @mixin IdeHelperUser
 */
final class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use UserStamps;
    use HasRoles;
    use HasPanelShield;

    protected $table = 'users';

    protected $casts = [
        'local_partner_id' => 'int',
        'email_verified_at' => 'datetime',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'email',
        'local_partner_id',
        'email_verified_at',
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
        'profile_photo_path',
        'signature_photo_path',
        'md5_signature_photo',
        'vigency',
        'created_by',
        'updated_by'
    ];


    protected function vigency(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value == 'active' ? true : false,
            set: fn (bool $value) => $value ? 'active' : 'inactive',
        );
    }

    public function users()
    {
        return $this->hasOne(User::class, 'updated_by');
    }

    public function local_partner()
    {
        return $this->belongsTo(LocalPartner::class);
    }

    public function alliances()
    {
        return $this->hasMany(Alliance::class, 'updated_by');
    }

    public function banking_informations()
    {
        return $this->hasMany(BankingInformation::class, 'updated_by');
    }

    public function children()
    {
        return $this->hasMany(Child::class, 'updated_by');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'updated_by');
    }

    public function communities()
    {
        return $this->hasMany(Community::class, 'updated_by');
    }

    public function community_managers()
    {
        return $this->hasMany(CommunityManagers::class, 'updated_by');
    }

    public function community_manager()
    {
        return $this->hasOne(CommunityManagers::class, 'manager_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'updated_by');
    }

    public function educational_institutions()
    {
        return $this->hasMany(EducationalInstitution::class, 'updated_by');
    }

    public function educational_records()
    {
        return $this->hasMany(EducationalRecord::class, 'updated_by');
    }

    public function family_members()
    {
        return $this->hasMany(FamilyMember::class, 'updated_by');
    }

    public function family_nuclei()
    {
        return $this->hasMany(FamilyNucleus::class, 'updated_by');
    }

    public function health_status_records()
    {
        return $this->hasMany(HealthStatusRecord::class, 'updated_by');
    }

    public function houses()
    {
        return $this->hasMany(House::class, 'updated_by');
    }

    public function letters()
    {
        return $this->hasMany(Letter::class, 'updated_by');
    }

    public function local_partners()
    {
        return $this->hasMany(LocalPartner::class, 'updated_by');
    }

    public function mailboxes()
    {
        return $this->hasMany(Mailbox::class, 'updated_by');
    }

    public function preschool_educational_records()
    {
        return $this->hasMany(PreschoolEducationalRecord::class, 'updated_by');
    }

    public function reasons_leaving_studies()
    {
        return $this->hasMany(ReasonsLeavingStudy::class, 'updated_by');
    }

    public function states()
    {
        return $this->hasMany(State::class, 'updated_by');
    }

    public function state()
    {
        return $this->hasOne(State::class, 'coordinator_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'updated_by');
    }

    public function zones()
    {
        return $this->hasMany(Zone::class, 'updated_by');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        //return str_ends_with($this->email, env('MAIL_DOMAIN'));
    }
}

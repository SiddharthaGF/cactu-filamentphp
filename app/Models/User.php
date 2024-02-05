<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\UserStamps;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Eloquent;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Storage;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $local_partner_id
 * @property string $password
 * @property string|null $profile_photo_path
 * @property string|null $signature
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
 * @property Collection|CommunityManagers[] $community_managers
 * @property CommunityManagers $community_manager
 * @property Collection|Contact[] $contacts
 * @property Collection|EducationalInstitution[] $educational_institutions
 * @property Collection|EducationalRecord[] $educational_records
 * @property Collection|FamilyMember[] $family_members
 * @property Collection|FamilyNucleus[] $family_nuclei
 * @property Collection|HealthStatusRecord[] $health_status_records
 * @property Collection|House[] $houses
 * @property Collection|Mail[] $letters
 * @property Collection|LocalPartner[] $local_partners
 * @property Collection|Mailbox[] $mailboxes
 * @property Collection|PreschoolEducationalRecord[] $preschool_educational_records
 * @property Collection|ReasonsLeavingStudy[] $reasons_leaving_studies
 * @property Collection|State[] $states
 * @property Collection|User[] $users
 * @property Collection|Zone[] $zones
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User permission($permissions)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCreatedBy($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLocalPartnerId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereProfilePhotoPath($value)
 * @method static Builder|User whereSignature($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUpdatedBy($value)
 *
 * @mixin IdeHelperUser
 *
 * @property-read User|null $creator
 * @property-read State|null $state
 * @property-read User|null $updater
 *
 * @method static Builder|User withoutPermission($permissions)
 * @method static Builder|User withoutRole($roles, $guard = null)
 *
 * @mixin Eloquent
 */
final class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens;
    use HasFactory;
    use HasPanelShield;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use UserStamps;

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
        'remember_token',
    ];

    protected $fillable = [
        'name',
        'email',
        'local_partner_id',
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
        'profile_photo_path',
        'avatar_url',
        'signature',
        'created_by',
        'updated_by',
    ];

    public function getFilamentAvatarUrl(): ?string
    {
        $url = $this->avatar_url ? Storage::url($this->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
        return $url;
    }

    public function users(): HasOne
    {
        return $this->hasOne(User::class, 'updated_by');
    }

    public function local_partner(): BelongsTo
    {
        return $this->belongsTo(LocalPartner::class);
    }

    public function alliances(): HasMany
    {
        return $this->hasMany(Alliance::class, 'updated_by');
    }

    public function banking_informations(): HasMany
    {
        return $this->hasMany(BankingInformation::class, 'updated_by');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Child::class, 'updated_by');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'updated_by');
    }

    public function communities(): HasMany
    {
        return $this->hasMany(Community::class, 'updated_by');
    }

    public function community_managers(): HasMany
    {
        return $this->hasMany(CommunityManagers::class, 'updated_by');
    }

    public function community_manager(): HasOne
    {
        return $this->hasOne(CommunityManagers::class, 'manager_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'updated_by');
    }

    public function educational_institutions(): HasMany
    {
        return $this->hasMany(EducationalInstitution::class, 'updated_by');
    }

    public function educational_records(): HasMany
    {
        return $this->hasMany(EducationalRecord::class, 'updated_by');
    }

    public function family_members(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'updated_by');
    }

    public function family_nuclei(): HasMany
    {
        return $this->hasMany(FamilyNucleus::class, 'updated_by');
    }

    public function health_status_records(): HasMany
    {
        return $this->hasMany(HealthStatusRecord::class, 'updated_by');
    }

    public function houses(): HasMany
    {
        return $this->hasMany(House::class, 'updated_by');
    }

    public function letters(): HasMany
    {
        return $this->hasMany(Mail::class, 'updated_by');
    }

    public function local_partners(): HasMany
    {
        return $this->hasMany(LocalPartner::class, 'updated_by');
    }

    public function mailboxes(): HasMany
    {
        return $this->hasMany(Mailbox::class, 'updated_by');
    }

    public function preschool_educational_records(): HasMany
    {
        return $this->hasMany(PreschoolEducationalRecord::class, 'updated_by');
    }

    public function reasons_leaving_studies(): HasMany
    {
        return $this->hasMany(ReasonsLeavingStudy::class, 'updated_by');
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class, 'updated_by');
    }

    public function state(): HasOne
    {
        return $this->hasOne(State::class, 'coordinator_id');
    }

    public function zones(): HasMany
    {
        return $this->hasMany(Zone::class, 'updated_by');
    }

    public function authentication(): MorphOne
    {
        return $this->morphOne(Authentication::class, 'authenticatable');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        //return str_ends_with($this->email, env('MAIL_DOMAIN'));
    }

    protected function vigency(): Attribute
    {
        return Attribute::make(
            get: fn(): bool => $this->hasRole('panel_user'),
        );
    }
}

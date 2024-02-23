<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

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
 * @property int|null $local_partner_id
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $avatar_url
 * @property string|null $signature
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property LocalPartner|null $local_partner
 * @property Collection|Child[] $children
 * @property CommunityManager $community_manager
 * @property State $state
 *
 * @package App\Models
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
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'email',
        'local_partner_id',
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
        'avatar_url',
        'signature',
        'created_by',
        'updated_by'
    ];

    protected function vigency(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->hasRole('panel_user'),
        );
    }

    public function local_partner()
    {
        return $this->belongsTo(LocalPartner::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class, 'reviewed_by');
    }

    public function community_manager()
    {
        return $this->hasOne(CommunityManager::class, 'manager_id');
    }

    public function state()
    {
        return $this->hasOne(State::class, 'coordinator_id');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $url = $this->avatar_url ? Storage::url($this->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
        return $url;
    }

<<<<<<< HEAD
=======
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

    public function community()
    {
        return $this->hasOneThrough(Community::class, CommunityManagers::class, 'manager_id', 'id', 'id', 'community_id');
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

>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        //return str_ends_with($this->email, env('MAIL_DOMAIN'));
    }

    public function scopeByRole($query, $roleName)
    {
<<<<<<< HEAD
        return $query->role([$roleName, 'super_admin']);
=======
        return Attribute::make(
            get: fn (): bool => $this->hasRole('panel_user'),
        );
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
    }

    public function scopeByRole($query, $roleName)
    {
        return $query->role([$roleName, 'super_admin']);
    }
}

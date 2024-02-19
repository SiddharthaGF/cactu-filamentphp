<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class House
 *
 * @property int $id
 * @property int $family_nucleus_id
 * @property string $property
 * @property string $home_space
 * @property string $roof
 * @property string $walls
 * @property string $floor
 * @property array $basic services
 * @property array $extras
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property FamilyNucleus $family_nucleus
 *
 * @method static \Illuminate\Database\Eloquent\Builder|House newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|House newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|House query()
 * @method static \Illuminate\Database\Eloquent\Builder|House whereBasicServices($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereFamilyNucleusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereHomeSpace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereRoof($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereWalls($value)
 *
 * @property array $basic_services
 * @property float $latitude
 * @property float $longitude
 * @property-read User|null $creator
 * @property array $location
 * @property-read User|null $updater
 *
 * @method static \Illuminate\Database\Eloquent\Builder|House whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereLongitude($value)
 *
 * @mixin \Eloquent
 */
final class House extends Model
{
    use UserStamps;

    protected $table = 'houses';

    protected $casts = [
        'family_nucleus_id' => 'int',
        'basic_services' => 'json',
        'extras' => 'json',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'family_nucleus_id',
        'property',
        'home_space',
        'roof',
        'walls',
        'floor',
        'latitude',
        'longitude',
        'location',
        'basic_services',
        'extras',
        'neighborhood',
        'created_by',
        'updated_by',
        'territory',
    ];

    protected $appends = [
        'location',
    ];

    public static function getComputedLocation(): string
    {
        return 'location';
    }

    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'latitude',
            'lng' => 'longitude',
        ];
    }

    public function setLocationAttribute(?array $location): void
    {
        if (is_array($location)) {
            $this->attributes['latitude'] = $location['lat'];
            $this->attributes['longitude'] = $location['lng'];
            unset($this->attributes['location']);
        }
    }

    public function getLocationAttribute(): array
    {
        return [
            'lat' => (float) $this->latitude,
            'lng' => (float) $this->longitude,
        ];
    }

    public function family_nucleus(): BelongsTo
    {
        return $this->belongsTo(FamilyNucleus::class);
    }

    public function risks_near_home(): HasMany
    {
        return $this->hasMany(RiskNearHome::class);
    }
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Location;

/**
 * Class House
 *
 * @property int $id
 * @property int $family_nucleus_id
 * @property int $property
 * @property int $home_space
 * @property int $roof
 * @property int $walls
 * @property int $floor
 * @property array $basic_services
 * @property float $latitude
 * @property float $longitude
 * @property string $neighborhood
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $territory
 *
 * @property FamilyNucleus $family_nucleus
 * @property Collection|RisksNearHome[] $risks_near_homes
 *
 * @package App\Models
 */
class House extends Model
{

    use UserStamps;

    protected $table = 'houses';

    protected $casts = [
        'family_nucleus_id' => 'int',
        'property' => 'int',
        'home_space' => 'int',
        'roof' => 'int',
        'walls' => 'int',
        'floor' => 'int',
        'basic_services' => 'json',
        'latitude' => 'float',
        'longitude' => 'float',
        'created_by' => 'int',
        'updated_by' => 'int',
        'territory' => Location::class
    ];

    protected $fillable = [
        'family_nucleus_id',
        'property',
        'home_space',
        'roof',
        'walls',
        'floor',
        'basic_services',
        'latitude',
        'longitude',
        'location',
        'neighborhood',
        'created_by',
        'updated_by',
        'territory'
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

    public function family_nucleus()
    {
        return $this->belongsTo(FamilyNucleus::class);
    }

    public function risks_near_home()
    {
        return $this->hasMany(RisksNearHome::class);
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}

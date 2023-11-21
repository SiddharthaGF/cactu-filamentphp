<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
 * @package App\Models
 * @property array $basic services
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
 * @mixin \Eloquent
 * @mixin IdeHelperHouse
 */
final class House extends Model
{
    use UserStamps;

    protected $table = 'houses';

    protected $casts = [
        'family_nucleus_id' => 'int',
        'basic services' => 'json',
        'extras' => 'json',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'family_nucleus_id',
        'property',
        'home_space',
        'roof',
        'walls',
        'floor',
        'basic services',
        'extras',
        'created_by',
        'updated_by'
    ];

    public function family_nucleus()
    {
        return $this->belongsTo(FamilyNucleus::class);
    }
}

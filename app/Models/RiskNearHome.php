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

/**
 * Class HealthStatusRecord
 *
 * @property int $id
 * @property int $child_id
 * @property int $health_status_record_id
 * @property string $type
 * @property int $percent
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Child $child
 * @property User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord whereChildId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord whereDisabilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord whereHealthProblemSpecification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord whereHealthStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthStatusRecord whereUpdatedBy($value)
 *
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @mixin \Eloquent
 */
final class RiskNearHome extends Model
{
    use UserStamps;

    protected $table = 'risks_near_home';

    protected $casts = [
        'house_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'house_id',
        'description',
        'created_by',
        'updated_by',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }
}

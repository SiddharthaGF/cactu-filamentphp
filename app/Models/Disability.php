<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
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
 * @method static Builder|HealthStatusRecord newModelQuery()
 * @method static Builder|HealthStatusRecord newQuery()
 * @method static Builder|HealthStatusRecord query()
 * @method static Builder|HealthStatusRecord whereChildId($value)
 * @method static Builder|HealthStatusRecord whereCreatedAt($value)
 * @method static Builder|HealthStatusRecord whereCreatedBy($value)
 * @method static Builder|HealthStatusRecord whereDisabilities($value)
 * @method static Builder|HealthStatusRecord whereHealthProblemSpecification($value)
 * @method static Builder|HealthStatusRecord whereHealthStatus($value)
 * @method static Builder|HealthStatusRecord whereId($value)
 * @method static Builder|HealthStatusRecord whereUpdatedAt($value)
 * @method static Builder|HealthStatusRecord whereUpdatedBy($value)
 *
 * @mixin IdeHelperHealthStatusRecord
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @mixin Eloquent
 */
final class Disability extends Model
{
    use UserStamps;

    protected $table = 'disabilities';

    protected $casts = [
        'child_id' => 'int',
        'type' => 'string',
        'percent' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'child_id',
        'type',
        'percent',
        'created_by',
        'updated_by',
    ];

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }
}

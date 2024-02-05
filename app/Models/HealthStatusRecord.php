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

/**
 * Class HealthStatusRecord
 *
 * @property int $id
 * @property int $child_id
 * @property string $health_status
 * @property array|null $health_problem_specification
 * @property array|null $disabilities
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
final class HealthStatusRecord extends Model
{
    use UserStamps;

    protected $table = 'health_status_record';

    protected $casts = [
        'child_id' => 'int',
        'health_problem_specification' => 'json',
        'disabilities' => 'json',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'child_id',
        'health_status',
        'especific_health_problems',
        'treatment',
        'created_by',
        'updated_by',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}

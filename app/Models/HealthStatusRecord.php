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
 * @package App\Models
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
 * @mixin \Eloquent
 * @mixin IdeHelperHealthStatusRecord
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
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'child_id',
        'health_status',
        'health_problem_specification',
        'disabilities',
        'created_by',
        'updated_by'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}

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
 * Class ReasonsLeavingStudy
 *
 * @property int $child_id
 * @property string $reason
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Child $child
 * @property User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ReasonsLeavingStudy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReasonsLeavingStudy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReasonsLeavingStudy query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReasonsLeavingStudy whereChildId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReasonsLeavingStudy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReasonsLeavingStudy whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReasonsLeavingStudy whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReasonsLeavingStudy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReasonsLeavingStudy whereUpdatedBy($value)
 *
 * @mixin IdeHelperReasonsLeavingStudy
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @mixin \Eloquent
 */
final class ReasonsLeavingStudy extends Model
{
    use UserStamps;

    public $incrementing = false;

    protected $table = 'reasons_leaving_study';

    protected $primaryKey = 'child_id';

    protected $casts = [
        'child_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'reason',
        'created_by',
        'updated_by',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}

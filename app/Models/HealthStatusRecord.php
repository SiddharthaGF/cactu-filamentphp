<?php

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
 * @property string|null $description
 * @property string|null $treatment
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Child $child
 *
 * @package App\Models
 */
class HealthStatusRecord extends Model
{

    use UserStamps;

    protected $table = 'health_status_record';

    protected $casts = [
        'child_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'child_id',
        'description',
        'treatment',
        'created_by',
        'updated_by'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}

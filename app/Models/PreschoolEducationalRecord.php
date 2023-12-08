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
 * Class PreschoolEducationalRecord
 *
 * @property int $id
 * @property int $child_id
 * @property string $name_institution
 * @property string $type
 * @property string $level
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Child $child
 * @property User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord whereChildId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord whereNameInstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PreschoolEducationalRecord whereUpdatedBy($value)
 *
 * @mixin IdeHelperPreschoolEducationalRecord
 *
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 *
 * @mixin \Eloquent
 */
final class PreschoolEducationalRecord extends Model
{
    use UserStamps;

    protected $table = 'preschool_educational_record';

    protected $casts = [
        'child_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'child_id',
        'name_institution',
        'type',
        'level',
        'created_by',
        'updated_by',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}

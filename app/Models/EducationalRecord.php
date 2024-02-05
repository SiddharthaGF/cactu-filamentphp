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
 * Class EducationalRecord
 *
 * @property int $id
 * @property int $child_id
 * @property int $educational_institution_id
 * @property int $grade
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Child $child
 * @property User $user
 * @property EducationalInstitution $educational_institution
 *
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalRecord whereChildId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalRecord whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalRecord whereEducationalInstitutionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalRecord whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EducationalRecord whereUpdatedBy($value)
 *
 * @mixin IdeHelperEducationalRecord
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @mixin \Eloquent
 */
final class EducationalRecord extends Model
{
    use UserStamps;

    protected $table = 'educational_record';

    protected $casts = [
        'child_id' => 'int',
        'educational_institution_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'child_id',
        'educational_institution_id',
        'status',
        'level',
        'fovorite_subject',
        'created_by',
        'updated_by',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function educational_institution()
    {
        return $this->belongsTo(EducationalInstitution::class);
    }
}

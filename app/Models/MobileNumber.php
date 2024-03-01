<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MobileNumber
 *
 * @property int $id
 * @property int $mobile_numerable_id
 * @property string $mobile_numerable_type
 * @property string $number
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MobileNumber extends Model
{

    use UserStamps;


    protected $table = 'mobile_numbers';

    protected $casts = [
        'mobile_numerable_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'mobile_numerable_id',
        'mobile_numerable_type',
        'number',
        'created_by',
        'updated_by'
    ];
}

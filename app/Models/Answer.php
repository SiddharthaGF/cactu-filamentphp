<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Answer
 *
 * @property int $id
 * @property int $mail_id
 * @property string $content
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Mail $mail
 */
class Answer extends Model implements HasMedia
{
    use InteractsWithMedia;
    use UserStamps;

    protected $table = 'answers';

    protected $casts = [
        'mail_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'mail_id',
        'content',
        'created_by',
        'updated_by',
    ];

    public function mail()
    {
        return $this->belongsTo(Mail::class);
    }
}

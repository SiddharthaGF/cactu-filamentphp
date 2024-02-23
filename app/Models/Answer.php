<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class Answer
 *
 * @property int $id
 * @property int $mail_id
 * @property string $content
 * @property string $attached_file_path
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $is_read
 *
 * @property Mail $mail
 *
 * @package App\Models
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
        'is_read' => 'int'
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

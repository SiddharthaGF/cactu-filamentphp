<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\StatusVigency;
use App\Traits\UserStamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mailbox
 *
 * @property int $id
 * @property int $vigency
 * @property int $created_by
 * @property int $updated_by
 * @property string $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Child $child
 * @property Collection|Mail[] $mails
 */
class Mailbox extends Model
{
    use UserStamps;

    protected $table = 'mailboxes';

    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'vigency' => StatusVigency::class,
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $hidden = [
        'token',
    ];

    protected $fillable = [
        'vigency',
        'created_by',
        'updated_by',
        'token',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class, 'id');
    }

    public function mails()
    {
        return $this->hasMany(Mail::class);
    }
}

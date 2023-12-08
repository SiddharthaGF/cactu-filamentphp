<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\StatusVigency;
use App\Traits\UserStamps;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mailbox
 *
 * @property int $id
 * @property string $vigency
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property Child $child
 * @property Collection|Mail[] $letters
 * @property-read int|null $letters_count
 *
 * @method static Builder|Mailbox newModelQuery()
 * @method static Builder|Mailbox newQuery()
 * @method static Builder|Mailbox query()
 * @method static Builder|Mailbox whereCreatedAt($value)
 * @method static Builder|Mailbox whereCreatedBy($value)
 * @method static Builder|Mailbox whereId($value)
 * @method static Builder|Mailbox whereUpdatedAt($value)
 * @method static Builder|Mailbox whereUpdatedBy($value)
 * @method static Builder|Mailbox whereVigency($value)
 *
 * @mixin IdeHelperMailbox
 *
 * @property string $token
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @method static Builder|Mailbox whereToken($value)
 *
 * @mixin Eloquent
 */
final class Mailbox extends Model
{
    use UserStamps;

    public $incrementing = false;

    protected $table = 'mailboxes';

    protected $casts = [
        'id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'vigency' => StatusVigency::class,
    ];

    protected $fillable = [
        'id',
        'vigency',
        'token',
        'created_by',
        'updated_by',
    ];

    private static $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function child()
    {
        return $this->belongsTo(Child::class, 'id');
    }

    public function mails()
    {
        return $this->hasMany(Mail::class);
    }

    public function answers()
    {
        return $this->hasMany(Answers::class);
    }

    public static function  generateToken(int $length = 15): string
    {
        return mb_substr(str_shuffle(self::$characters), 0, $length);
    }
}

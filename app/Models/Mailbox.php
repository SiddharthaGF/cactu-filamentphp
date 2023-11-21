<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\UserStamps;
use Carbon\Carbon;
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
 * @property Collection|Letter[] $letters
 * @package App\Models
 * @property-read int|null $letters_count
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mailbox whereVigency($value)
 * @mixin \Eloquent
 * @mixin IdeHelperMailbox
 */
final class Mailbox extends Model
{
    use UserStamps;

    public $incrementing = false;
    protected $table = 'mailboxes';

    protected $casts = [
        'id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'vigency',
        'created_by',
        'updated_by'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class, 'id');
    }

    public function letters()
    {
        return $this->hasMany(Letter::class);
    }
}

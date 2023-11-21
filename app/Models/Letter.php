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
 * Class Letter
 *
 * @property int $id
 * @property int $mailbox_id
 * @property string $letter_type
 * @property string $status
 * @property string $letter_photo_1_path
 * @property string|null $letter_photo_2_path
 * @property string|null $answer
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property Mailbox $mailbox
 * @property Ticket $ticket
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Letter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereLetterPhoto1Path($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereLetterPhoto2Path($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereLetterType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereMailboxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereUpdatedBy($value)
 * @mixin \Eloquent
 * @mixin IdeHelperLetter
 */
final class Letter extends Model
{
    use UserStamps;

    protected $table = 'letters';

    protected $casts = [
        'mailbox_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'mailbox_id',
        'letter_type',
        'status',
        'letter_photo_1_path',
        'letter_photo_2_path',
        'answer',
        'created_by',
        'updated_by'
    ];

    public function mailbox()
    {
        return $this->belongsTo(Mailbox::class);
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
}

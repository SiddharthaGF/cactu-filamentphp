<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\MailStatus;
use App\Enums\MailsTypes;
use App\Traits\UserStamps;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Mail
 *
 * @property int $id
 * @property int $mailbox_id
 * @property string $letter_type
 * @property MailStatus $status
 * @property string $letter_photo_1_path
 * @property string|null $letter_photo_2_path
 * @property string|null $answer
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property Answers $answers
 * @property Mailbox $mailbox
 *
 * @method static Builder|Mail newModelQuery()
 * @method static Builder|Mail newQuery()
 * @method static Builder|Mail query()
 * @method static Builder|Mail whereAnswer($value)
 * @method static Builder|Mail whereCreatedAt($value)
 * @method static Builder|Mail whereCreatedBy($value)
 * @method static Builder|Mail whereId($value)
 * @method static Builder|Mail whereLetterPhoto1Path($value)
 * @method static Builder|Mail whereLetterPhoto2Path($value)
 * @method static Builder|Mail whereLetterType($value)
 * @method static Builder|Mail whereMailboxId($value)
 * @method static Builder|Mail whereStatus($value)
 * @method static Builder|Mail whereUpdatedAt($value)
 * @method static Builder|Mail whereUpdatedBy($value)
 *
 * @mixin IdeHelperLetter
 *
 * @property string $type
 * @property int $awswer_to
 * @property int $has_ticket
 * @property string $photo_path
 * @property-read User|null $creator
 * @property-read Mail|null $from
 * @property-read Mail|null $to
 * @property-read User|null $updater
 *
 * @method static Builder|Mail whereAwswerTo($value)
 * @method static Builder|Mail whereHasTicket($value)
 * @method static Builder|Mail wherePhotoPath($value)
 * @method static Builder|Mail whereType($value)
 *
 * @mixin Eloquent
 */
//#[ObservedBy([MailChangeStatusObserver::class])]
final class Mail extends Model
{
    use UserStamps;

    protected $table = 'mails';

    protected $casts = [
        'mailbox_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'status' => MailStatus::class,
        'type' => MailsTypes::class,
    ];

    protected $fillable = [
        'mailbox_id',
        'type',
        'status',
        'reply_mail_id',
        'created_by',
        'updated_by',
    ];

    public function from(): BelongsTo
    {
        return $this->belongsTo(Mail::class);
    }

    public function to(): HasOne
    {
        return $this->hasOne(Mail::class, 'answer_to');
    }

    public function mailbox(): BelongsTo
    {
        return $this->belongsTo(Mailbox::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answers::class);
    }

}

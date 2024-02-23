<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\MailStatus;
use App\Enums\MailsTypes;
<<<<<<< HEAD
=======
use App\Traits\UserStamps;
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8

/**
 * Class Mail
 *
 * @property int $id
 * @property int $mailbox_id
<<<<<<< HEAD
 * @property int $type
 * @property int|null $reply_mail_id
 * @property int $status
=======
 * @property string $letter_type
 * @property MailStatus $status
 * @property string $letter_photo_1_path
 * @property string|null $letter_photo_2_path
 * @property string|null $answer
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
<<<<<<< HEAD
 *
 * @property Mailbox $mailbox
 * @property Mail|null $mail
 * @property Collection|Answer[] $answers
 * @property Collection|Mail[] $mails
=======
 * @property User $user
 * @property Answers $answers
 * @property Mailbox $mailbox
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
 *
 * @package App\Models
 */
<<<<<<< HEAD
class Mail extends Model
=======
//#[ObservedBy([MailChangeStatusObserver::class])]
final class Mail extends Model
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
{
	protected $table = 'mails';

	protected $casts = [
		'mailbox_id' => 'int',
		'type' => MailsTypes::class,
		'reply_mail_id' => 'int',
		'status' => MailStatus::class,
		'created_by' => 'int',
		'updated_by' => 'int'
	];

<<<<<<< HEAD
	protected $fillable = [
		'mailbox_id',
		'type',
		'reply_mail_id',
		'status',
		'created_by',
		'updated_by'
	];
=======
    protected $casts = [
        'mailbox_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'status' => MailStatus::class,
        'type' => MailsTypes::class,
    ];
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8

	public function mailbox()
	{
		return $this->belongsTo(Mailbox::class);
	}

<<<<<<< HEAD
	public function mail()
	{
		return $this->belongsTo(Mail::class, 'reply_mail_id');
	}

	public function answers()
	{
		return $this->hasMany(Answer::class);
	}
=======
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
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8

	public function mails()
	{
		return $this->hasMany(Mail::class, 'reply_mail_id');
	}
}

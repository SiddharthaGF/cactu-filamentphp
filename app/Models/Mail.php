<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\MailStatus;
use App\Enums\MailsTypes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mail
 *
 * @property int $id
 * @property int $mailbox_id
 * @property int $type
 * @property int|null $reply_mail_id
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Mailbox $mailbox
 * @property Mail|null $mail
 * @property Collection|Answer[] $answers
 * @property Collection|Mail[] $mails
 *
 * @package App\Models
 */
class Mail extends Model
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

	protected $fillable = [
		'mailbox_id',
		'type',
		'reply_mail_id',
		'status',
		'created_by',
		'updated_by'
	];

	public function mailbox()
	{
		return $this->belongsTo(Mailbox::class);
	}

	public function mail()
	{
		return $this->belongsTo(Mail::class, 'reply_mail_id');
	}

	public function answers()
	{
		return $this->hasMany(Answer::class);
	}

	public function mails()
	{
		return $this->hasMany(Mail::class, 'reply_mail_id');
	}
}

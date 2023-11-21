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
 * Class Ticket
 *
 * @property int $id
 * @property int $letter_id
 * @property Carbon $date_request
 * @property Carbon $due_date
 * @property string $ticket_photo_path
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property Letter $letter
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereDateRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereLetterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereTicketPhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedBy($value)
 * @mixin \Eloquent
 * @mixin IdeHelperTicket
 */
final class Ticket extends Model
{
    use UserStamps;

    protected $table = 'tickets';

    protected $casts = [
        'letter_id' => 'int',
        'date_request' => 'datetime',
        'due_date' => 'datetime',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'letter_id',
        'date_request',
        'due_date',
        'ticket_photo_path',
        'created_by',
        'updated_by'
    ];

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}

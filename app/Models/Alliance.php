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
 * Class Alliance
 *
 * @property int $id
 * @property string $alliance
 * @property string $country
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User $user
 * @property Collection|Contact[] $contacts
 * @package App\Models
 * @property-read int|null $contacts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Alliance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alliance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alliance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Alliance whereAlliance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alliance whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alliance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alliance whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alliance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alliance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alliance whereUpdatedBy($value)
 * @mixin \Eloquent
 * @mixin IdeHelperAlliance
 */
final class Alliance extends Model
{

    use UserStamps;

    protected $table = 'alliances';

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'alliance',
        'country',
        'created_by',
        'updated_by'
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}

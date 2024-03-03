<?php

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
 * @property Collection|Contact[] $contacts
 */
class Alliance extends Model
{
    use UserStamps;

    protected $table = 'alliances';

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'alliance',
        'country',
        'created_by',
        'updated_by',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}

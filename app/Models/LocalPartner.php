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
 * Class LocalPartner
 *
 * @property int $id
 * @property string $name
 * @property string|null $alias
 * @property string|null $description
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|User[] $users
 */
class LocalPartner extends Model
{
    use UserStamps;

    protected $table = 'local_partners';

    protected $casts = [
        'created_by' => 'int',
        'updated_by' => 'int',
    ];

    protected $fillable = [
        'name',
        'alias',
        'description',
        'created_by',
        'updated_by',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

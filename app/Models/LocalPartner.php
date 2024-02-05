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
 * Class LocalPartner
 *
 * @property int $id
 * @property string $name
 * @property string|null $alias
 * @property string|null $description
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User|null $user
 * @property Collection|User[] $users
 * @property-read int|null $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPartner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPartner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPartner query()
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPartner whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPartner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPartner whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPartner whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPartner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPartner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPartner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LocalPartner whereUpdatedBy($value)
 *
 * @mixin IdeHelperLocalPartner
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @mixin \Eloquent
 */
final class LocalPartner extends Model
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

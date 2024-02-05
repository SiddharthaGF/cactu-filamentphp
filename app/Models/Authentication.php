<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Zone
 *
 * @property string $city_code
 * @property string $code
 * @property string $name
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property City $city
 * @property User $user
 * @property Collection|Community[] $communities
 * @property-read int|null $communities_count
 *
 * @method static Builder|Zone newModelQuery()
 * @method static Builder|Zone newQuery()
 * @method static Builder|Zone query()
 * @method static Builder|Zone whereNumber($value)
 * @method static Builder|Zone whereCreatedAt($value)
 * @method static Builder|Zone whereCreatedBy($value)
 * @method static Builder|Zone whereUpdatedAt($value)
 * @method static Builder|Zone whereUpdatedBy($value)
 *
 * @mixin IdeHelperZone
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 *
 * @mixin Eloquent
 */
final class Authentication extends Model
{

    protected $table = 'breezy_sessions';

    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }
}

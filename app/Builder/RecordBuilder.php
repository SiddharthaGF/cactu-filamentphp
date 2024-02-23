<?php

declare(strict_types=1);

namespace App\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

final class RecordBuilder extends Builder
{
    public static function correspondingRecords($query): Builder
    {
        $role_name = env('ADMIN_ROLE_NAME', 'super_admin');
        $user = Auth::user();
        return $user->hasRole($role_name)
            ? $query
            : $query->where("{$query->from}.updated_by", $user->id);
    }
}

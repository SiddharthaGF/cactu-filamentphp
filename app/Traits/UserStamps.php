<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;

trait UserStamps
{
    public static function bootUserStamps(): void
    {
        static::creating(function ($model): void {
            if ( ! $model->isDirty('created_by')) {
                $model->created_by = auth()->user()->id ?? 1;
            }
            if ( ! $model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id ?? 1;
            }
        });

        static::updating(function ($model): void {
            if ( ! $model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

<?php

declare(strict_types=1);

namespace App\Traits;

trait HasRecords
{
    public static function bootHasRecords(): void
    {
        static::creating(function ($model): void {

            if (! $model->isDirty('manager_id')) {
                $model->manager_id = auth()->user()->id;
            }
        });
    }
}

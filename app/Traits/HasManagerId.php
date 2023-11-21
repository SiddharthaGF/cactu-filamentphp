<?php

namespace App\Traits;

trait HasManagerId
{
    public static function bootHasManagerId()
    {
        static::creating(function ($model) {

            if (!$model->isDirty('manager_id')) {
                $model->manager_id = auth()->user()->id;
            }
        });
    }
}

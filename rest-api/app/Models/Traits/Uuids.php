<?php

namespace App\Models\Traits;

use Webpatser\Uuid\Uuid;

trait Uuids
{
    /**
     * Boot function from Laravel model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }
}
<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

trait HasUuid
{
    /**
     * Boot function from Laravel model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate(4)->string;
        });
    }
}
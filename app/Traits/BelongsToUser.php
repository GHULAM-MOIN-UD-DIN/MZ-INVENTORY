<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToUser
{
    protected static function bootBelongsToUser()
    {
        // Automatically inject user_id when creating new records
        static::creating(function ($model) {
            if (Auth::check() && !$model->user_id) {
                $model->user_id = Auth::id();
            }
        });

        // Automatically filter select queries to logged-in user's records
        static::addGlobalScope('user_scope', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where($builder->getQuery()->from . '.user_id', Auth::id());
            }
        });
    }
}

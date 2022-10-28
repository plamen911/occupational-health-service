<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

/**
 * Trait Updater
 */
trait Updater
{
    protected static function boot()
    {
        parent::boot();

        /* * During a model create Eloquent will also update the updated_at field so * need to have the updated_by field here as well * */
        static::creating(function (Model $model) {
            if (Auth::check()) {
                if (Schema::hasColumn($model->getTable(), 'created_by')) {
                    $model->created_by = Auth::id();
                }
                if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                    $model->updated_by = Auth::id();
                }
            }
        });

        static::updating(function (Model $model) {
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                if (Auth::check()) {
                    $model->updated_by = Auth::id();
                }
            }
        });

        /*
         * Deleting a model is slightly different than creating or deleting. For
         * deletes we need to save the model first with the deleted_by field
         * */
        static::deleting(function (Model $model) {
            if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
                if (Auth::check()) {
                    $model->deleted_by = Auth::id();
                }
                $model->save();
            }
        });
    }
}

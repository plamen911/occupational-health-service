<?php

namespace App\Providers;

use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // https://planetscale.com/blog/laravels-safety-mechanisms

        Model::preventsLazyLoading();
        Model::preventSilentlyDiscardingAttributes();
//        Model::preventAccessingMissingAttributes();

//        Model::shouldBeStrict();

        // But in production, log the violation instead of throwing an exception.
        if ($this->app->isProduction()) {
            Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
                $class = get_class($model);

                info("Attempted to lazy load [{$relation}] on model [{$class}].");
            });
        }

        // Log a warning if we spend more than a total of 2000ms querying.
        DB::whenQueryingForLongerThan(2000, function (Connection $connection) {
            Log::warning("Database queries exceeded 2 seconds on {$connection->getName()}");
        });

        // Log a warning if we spend more than 1000ms on a single query.
        DB::listen(function ($query) {
            if ($query->time > 1000) {
                Log::warning('An individual database query exceeded 1 second.', [
                    'sql' => $query->sql,
                ]);
            }
        });

        if ($this->app->runningInConsole()) {
            // Log slow commands.
            $this->app[ConsoleKernel::class]->whenCommandLifecycleIsLongerThan(
                5000,
                function ($startedAt, $input, $status) {
                    Log::warning('A command took longer than 5 seconds.');
                }
            );
        } else {
            // Log slow requests.
            $this->app[HttpKernel::class]->whenRequestLifecycleIsLongerThan(
                5000,
                function ($startedAt, $request, $response) {
                    Log::warning('A request took longer than 5 seconds.');
                }
            );
        }
    }
}

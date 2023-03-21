<?php

namespace SYSOTEL\OTA\Common;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('sortByDate', function (string $column, bool $descending = true) {
            /* @var $this Collection */
            return $this->sortBy(function ($datum) use ($column) {
                return strtotime(((object)$datum)->$column);
            }, SORT_REGULAR, $descending);
        });

        $this->publishes([
            __DIR__.'/../config/user-tokens.php' => config_path('user-tokens.php'),
            __DIR__.'/../config/common.php' => config_path('common.php'),
            __DIR__.'/../config/mongo-odm.php' => config_path('mongo-odm.php'),
        ]);
    }
}

<?php

namespace SYSOTEL\OTA\Common\Services\IAM;

use Illuminate\Support\ServiceProvider;

class IAMServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('IAM', function () {
            return new IAM;
        });
    }

    public function boot()
    {
        //
    }
}

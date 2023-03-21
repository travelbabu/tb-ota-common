<?php

namespace SYSOTEL\OTA\Common\Services\OtaContractServices;

use Illuminate\Support\ServiceProvider;

class OtaContractServicesProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('OtaContractStorageManager', function(){
           return new OtaContractStorageManager(
                $this->driver()
           );
        });
    }

    /**
     * @return string
     */
    protected function driver(): string
    {
        return config('filesystems.property_private');
    }
}

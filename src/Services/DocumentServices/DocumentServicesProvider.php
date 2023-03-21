<?php

namespace SYSOTEL\OTA\Common\Services\DocumentServices;

use Illuminate\Support\ServiceProvider;

class DocumentServicesProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('DocumentStorageManager', function(){
           return new DocumentStorageManager(
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

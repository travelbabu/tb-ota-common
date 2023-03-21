<?php

namespace SYSOTEL\OTA\Common\Services\CorporateDocumentServices;

use Illuminate\Support\ServiceProvider;

class CorporateAccountServicesProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CorporateAccountStorageManager', function(){
           return new CorporateAccountStorageManager(
                $this->driver()
           );
        });
    }

    /**
     * @return string
     */
    protected function driver(): string
    {
        return config('filesystems.corporate_users_private');
    }
}

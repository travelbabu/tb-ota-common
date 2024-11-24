<?php

namespace SYSOTEL\OTA\Common\Services\StorageServices;

use Illuminate\Support\ServiceProvider;

class StorageServicesProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->bindPropertyPublicStorage();
        $this->bindPropertyPrivateStorage();
        $this->bindPropertyBookingStorage();
    }

    /**
     * @return void
     */
    protected function bindPropertyPublicStorage(): void
    {
        $this->app->bind('PropertyPublicStorage', function () {
            return new PropertyPublicStorage(
                $this->publicDriver()
            );
        });
    }

    /**
     * @return void
     */
    protected function bindPropertyPrivateStorage(): void
    {
        $this->app->bind('PropertyPrivateStorage', function () {
            return new PropertyPrivateStorage(
                $this->privateDriver()
            );
        });
    }

    /**
     * @return void
     */
    protected function bindPropertyBookingStorage(): void
    {
        $this->app->bind('PropertyBookingStorage', function () {
            return new PropertyBookingStorage(
                $this->privateDriver()
            );
        });
    }

    /**
     * @return string
     */
    protected function privateDriver(): string
    {
        return config('filesystems.property_private');
    }

    /**
     * @return string
     */
    protected function publicDriver(): string
    {
        return config('filesystems.property_public');
    }
}

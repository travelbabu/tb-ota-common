<?php

namespace SYSOTEL\OTA\Common\Services\ImageServices;

use Illuminate\Support\ServiceProvider;

class ImageServicesProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ImageStorageManager', function () {
            return new ImageStorageManager(
                $this->driver(), $this->imageSizes()
            );
        });
    }

    /**
     * @return string
     */
    protected function driver(): string
    {
        return config('filesystems.property_public');
    }

    /**
     * @return array
     */
    protected function imageSizes(): array
    {
        return config('settings.image_dimensions');
    }
}

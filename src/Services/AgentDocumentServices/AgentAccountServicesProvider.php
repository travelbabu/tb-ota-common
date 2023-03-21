<?php

namespace SYSOTEL\OTA\Common\Services\AgentDocumentServices;

use Illuminate\Support\ServiceProvider;

class AgentAccountServicesProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('AgentAccountStorageManager', function(){
           return new AgentAccountStorageManager(
                $this->driver()
           );
        });
    }

    /**
     * @return string
     */
    protected function driver(): string
    {
        return config('filesystems.agent_private');
    }
}

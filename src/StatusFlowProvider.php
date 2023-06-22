<?php

namespace HermesHerrera\StatusFlow;

use Illuminate\Support\ServiceProvider;

class StatusFlowProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations/');
        }

        $this->loadTranslationsFrom(__DIR__.'/../lang/', 'StatusFlow');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/status_flow.php', 'status_flow');
    }
}
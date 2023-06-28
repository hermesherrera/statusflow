<?php

namespace HermesHerrera\StatusFlow;

use Illuminate\Support\ServiceProvider;
use HermesHerrera\StatusFlow\Models\StatusFlow;
use HermesHerrera\StatusFlow\Observers\StatusFlowObserver;

class StatusFlowProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations/');
        }

        $this->loadTranslationsFrom(__DIR__.'/../lang/', 'StatusFlow');

        StatusFlow::observe(StatusFlowObserver::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/status_flow.php', 'status_flow');
    }
}
<?php

namespace HermesHerrera\StatusFlow;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use HermesHerrera\StatusFlow\Models\StatusFlow;
use HermesHerrera\StatusFlow\Policies\StatusFlowPolicy;
use HermesHerrera\StatusFlow\Observers\StatusFlowObserver;

class StatusFlowProvider extends ServiceProvider
{
    private $policies = [
        StatusFlow::class => StatusFlowPolicy::class,
    ];

    private function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations/');
        }

        $this->loadTranslationsFrom(__DIR__.'/../lang/', 'StatusFlow');

        StatusFlow::observe(StatusFlowObserver::class);

        $this->registerPolicies();


        $timestamp = date('Y_m_d_His', time());

        $this->publishes([
            __DIR__.'/../database/migrations/tenant/create_status_flow_tables.php.stub' => database_path('migrations/tenant/'. $timestamp .'_create_status_flow_tables.php'),
        ], 'migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/status_flow.php', 'status_flow');
    }
}
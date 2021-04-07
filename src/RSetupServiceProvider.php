<?php

namespace Stats4SD\LaravelRSetup;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RSetupServiceProvider extends ServiceProvider
{
    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupCommand::class,
            ]);
        }
    }
}

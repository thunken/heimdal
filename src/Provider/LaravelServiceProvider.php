<?php

namespace Thunken\Heimdal\Provider;

use Illuminate\Support\ServiceProvider as BaseProvider;
use Thunken\Heimdal\Reporters\BugsnagReporter;
use Thunken\Heimdal\Reporters\RollbarReporter;
use Thunken\Heimdal\Reporters\SentryReporter;

class LaravelServiceProvider extends BaseProvider {

    public function register()
    {
        $this->loadConfig();
        $this->registerAssets();
        $this->bindReporters();
    }

    private function registerAssets()
    {
        $this->publishes([
            __DIR__.'/../config/heimdal.php' => config_path('heimdal.php')
        ]);
    }

    private function loadConfig()
    {
        if ($this->app['config']->get('heimdal') === null) {
            $this->app['config']->set('heimdal', require __DIR__.'/../config/heimdal.php');
        }
    }

    private function bindReporters()
    {
        $this->app->bind(BugsnagReporter::class, function ($app) {
            return function (array $config) {
                return new BugsnagReporter($config);
            };
        });

        $this->app->bind(SentryReporter::class, function ($app) {
            return function (array $config) {
                return new SentryReporter($config);
            };
        });

        $this->app->bind(RollbarReporter::class, function ($app) {
            return function (array $config) {
                return new RollbarReporter($config);
            };
        });
    }
}

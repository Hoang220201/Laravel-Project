<?php

namespace Packages\Exchange\Providers;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;

class ExchangeServiceProvider extends ServiceProvider
    {

        /**
        * Register bindings in the container.
        */
        public function register()
        {
    
        }

        public function boot()
        {

            $modulePath = __DIR__.'/../../';
            $moduleName = 'Exchange';

            // boot migartion
            if (File::exists($modulePath . "database/migrations")) {
                $this->loadMigrationsFrom($modulePath . "database/migrations/", $moduleName);
            }

            // boot route
            if (File::exists($modulePath."routes/routes.php")) {
                $this->loadRoutesFrom($modulePath."/routes/routes.php");
            }
            // boot views
            if (File::exists($modulePath . "resources/views")) {
                $this->loadViewsFrom($modulePath . "resources/views", $moduleName);
            }

            $this->publishes([
                $modulePath . "resources/views" => resource_path('views/vendor/package/exchange'),
            ], 'views');
        
        }
    }
?>
<?php

namespace App\Application\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrateDirectory();
    }
    private function loadMigrateDirectory():void
    {
        $mainPath = database_path('migrations');

        $directories = glob(app_path('Domain/') . '**/Migration' , GLOB_ONLYDIR);

        $paths = array_merge([$mainPath], $directories);
        $this->loadMigrationsFrom($paths);
    }
}

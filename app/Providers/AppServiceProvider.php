<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\admin\matricula\domain\interface\MatriculaInterface;
use Src\admin\matricula\infrastructure\repositories\StoreMatriculaRepositories;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //$this->app->bind(MatriculaInterface::class, StoreMatriculaRepositories::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

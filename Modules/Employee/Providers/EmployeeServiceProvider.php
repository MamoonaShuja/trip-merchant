<?php

namespace Modules\Employee\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\Http\UserAgentContract;
use Modules\Core\Services\Http\UserAgentService;
use Modules\User\Contracts\Repositories\UserRepositoryContract;
use Modules\User\Contracts\Services\AccessTokenContract;
use Modules\User\Contracts\Services\UserContract;
use Modules\User\Repositories\UserRepository;
use Modules\User\Services\AccessTokenService;
use Modules\User\Services\UserService;

class EmployeeServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Employee';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'employee';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        // Services
        $this->app->bind(UserContract::class, UserService::class);
        $this->app->bind(AccessTokenContract::class, AccessTokenService::class);
        $this->app->bind(UserAgentContract::class, UserAgentService::class);
        // Repositories
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

<?php

namespace Modules\User\Providers;

use Modules\Core\Contracts\Http\UserAgentContract;
use Modules\Core\Services\Http\UserAgentService;
use Modules\User\Contracts\Repositories\SubscriberRepositoryContract;
use Modules\User\Contracts\Repositories\UserRepositoryContract;
use Modules\User\Contracts\Services\SubscriberContract;
use Modules\User\Contracts\Services\UserContract;
use Modules\User\Entities\User;
use Illuminate\Support\ServiceProvider;
use Modules\User\Observers\UserObserver;
use Modules\User\Repositories\SubscriberRepository;
use Modules\User\Repositories\UserRepository;
use Modules\User\Services\AccessTokenService;
use Modules\User\Contracts\Services\AccessTokenContract;
use Illuminate\Contracts\Container\BindingResolutionException;
use Modules\User\Services\SubscriberService;
use Modules\User\Services\UserService;

final class UserServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected string $moduleName = 'User';

    /**
     * @var string $moduleNameLower
     */
    protected string $moduleNameLower = 'user';

    /**
     * Boot the application events.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        // Register User Observer
//        User::observe(UserObserver::class);
    }

    /**
     * Register config.
     *
     * @return void
     * @throws BindingResolutionException
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        // Services
        $this->app->bind(UserContract::class, UserService::class);
        $this->app->bind(AccessTokenContract::class, AccessTokenService::class);
        $this->app->bind(UserAgentContract::class, UserAgentService::class);
        $this->app->bind(SubscriberContract::class, SubscriberService::class);
        // Repositories
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(SubscriberRepositoryContract::class, SubscriberRepository::class);

    }
}

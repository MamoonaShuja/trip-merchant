<?php

namespace Modules\Organizer\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\Http\UserAgentContract;
use Modules\Core\Services\Http\UserAgentService;
use Modules\Organizer\Contracts\Repositories\OrganizerSliderRepositoryContract;
use Modules\Organizer\Contracts\Repositories\SettingsRepositoryContract;
use Modules\Organizer\Contracts\Services\OrganizationSliderContract;
use Modules\Organizer\Contracts\Services\SettingsContract;
use Modules\Organizer\Repositories\OrganizerSliderRepository;
use Modules\Organizer\Repositories\SettingsRepository;
use Modules\Organizer\Services\OrganizationSliderService;
use Modules\Organizer\Services\SettingsService;
use Modules\User\Contracts\Repositories\UserRepositoryContract;
use Modules\User\Contracts\Services\AccessTokenContract;
use Modules\User\Contracts\Services\UserContract;
use Modules\User\Repositories\UserRepository;
use Modules\User\Services\AccessTokenService;
use Modules\User\Services\UserService;

class OrganizerServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Organizer';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'organizer';

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
        $this->app->bind(SettingsContract::class, SettingsService::class);
        $this->app->bind(OrganizationSliderContract::class, OrganizationSliderService::class);

        // Repositories
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(SettingsRepositoryContract::class, SettingsRepository::class);
        $this->app->bind(OrganizerSliderRepositoryContract::class, OrganizerSliderRepository::class);

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

}

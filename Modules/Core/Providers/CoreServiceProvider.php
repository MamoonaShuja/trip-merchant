<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\Http\UserAgentContract;
use Modules\Core\Contracts\Repositories\PermissionRepositoryContract;
use Modules\Core\Contracts\Repositories\RoleRepositoryContract;
use Modules\Core\Contracts\Repositories\ScheduleDemoRepositoryContract;
use Modules\Core\Contracts\Security\OtpContract;
use Modules\Core\Contracts\Services\Filesystem\FilesystemContract;
use Modules\Core\Contracts\Services\PermissionContract;
use Modules\Core\Contracts\Services\RoleContract;
use Modules\Core\Contracts\Services\ScheduleDemoContract;
use Modules\Core\Repositories\PermissionRepository;
use Modules\Core\Repositories\RoleRepository;
use Modules\Core\Repositories\ScheduleDemoRepository;
use Modules\Core\Services\Core\Security\OtpService;
use Modules\Core\Services\Filesystem\FilesystemService;
use Modules\Core\Services\Http\UserAgentService;
use Modules\Core\Services\PermissionService;
use Modules\Core\Services\RoleService;
use Modules\Core\Services\ScheduleDemoService;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Core';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'core';

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
        $this->app->bind(UserAgentContract::class, UserAgentService::class);
        $this->app->bind(OtpContract::class, OtpService::class);

        $this->app->bind(FilesystemContract::class, fn() => $this->app->environment("prod") ?
            new FilesystemService(Storage::disk("s3")) : new FilesystemService(Storage::disk("public"))
        );

        //        Services
        $this->app->bind(RoleContract::class, RoleService::class);
        $this->app->bind(PermissionContract::class, PermissionService::class);
        $this->app->bind(ScheduleDemoContract::class, ScheduleDemoService::class);


//        Repositories
        $this->app->bind(RoleRepositoryContract::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryContract::class, PermissionRepository::class);
        $this->app->bind(ScheduleDemoRepositoryContract::class, ScheduleDemoRepository::class);

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

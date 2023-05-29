<?php

namespace Modules\SupplierApi\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\SupplierApi\Console\ScrapData;
use Modules\SupplierApi\Console\ScrapTourData;
use Modules\SupplierApi\Contracts\Repositories\ApiSupplierRepositoryContract;
use Modules\SupplierApi\Contracts\Repositories\ApiTourIdRepositoryContract;
use Modules\SupplierApi\Contracts\Services\ApiSupplierContract;
use Modules\SupplierApi\Contracts\Services\ApiTourIdContract;
use Modules\SupplierApi\Contracts\Services\ValidatingForeignKeyContract;
use Modules\SupplierApi\Repositories\ApiSupplierRepository;
use Modules\SupplierApi\Repositories\ApiTourIdRepository;
use Modules\SupplierApi\Services\ApiSupplierService;
use Modules\SupplierApi\Services\ApiTourIdService;
use Modules\SupplierApi\Services\ValidatingForeignKeyService;

class SupplierApiServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'SupplierApi';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'supplierapi';

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

        $this->commands([
            ScrapData::class,
            ScrapTourData::class,
        ]);
        $this->app->register(RouteServiceProvider::class);
        //        Services
        $this->app->bind(ApiSupplierContract::class , ApiSupplierService::class);
        $this->app->bind(ApiTourIdContract::class , ApiTourIdService::class);
        $this->app->bind(ValidatingForeignKeyContract::class , ValidatingForeignKeyService::class);

//        Repositories
        $this->app->bind(ApiSupplierRepositoryContract::class , ApiSupplierRepository::class);
        $this->app->bind(ApiTourIdRepositoryContract::class , ApiTourIdRepository::class);

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

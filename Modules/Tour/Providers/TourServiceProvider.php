<?php

namespace Modules\Tour\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Tour\Contracts\Repositories\AccommodationAmenityRepositoryContract;
use Modules\Tour\Contracts\Repositories\AccommodationRepositoryContract;
use Modules\Tour\Contracts\Repositories\CabinDeckRepositoryContract;
use Modules\Tour\Contracts\Repositories\CityRepositoryContract;
use Modules\Tour\Contracts\Repositories\CountryRepositoryContract;
use Modules\Tour\Contracts\Repositories\DepartureDateRepositoryContract;
use Modules\Tour\Contracts\Repositories\DestinationRepositoryContract;
use Modules\Tour\Contracts\Repositories\EssentialInfoRepositoryContract;
use Modules\Tour\Contracts\Repositories\ItineraryRepositoryContract;
use Modules\Tour\Contracts\Repositories\LocationRepositoryContract;
use Modules\Tour\Contracts\Repositories\QuoteRepositoryContract;
use Modules\Tour\Contracts\Repositories\SearchRepositoryContract;
use Modules\Tour\Contracts\Repositories\TourRepositoryContract;
use Modules\Tour\Contracts\Repositories\TravelStyleRepositoryContract;
use Modules\Tour\Contracts\Repositories\VideoRepositoryContract;
use Modules\Tour\Contracts\Services\AccommodationAmenityContract;
use Modules\Tour\Contracts\Services\AccommodationContract;
use Modules\Tour\Contracts\Services\CabinDeckContract;
use Modules\Tour\Contracts\Services\CityContract;
use Modules\Tour\Contracts\Services\CountryContract;
use Modules\Tour\Contracts\Services\DepartureDateContract;
use Modules\Tour\Contracts\Services\DestinationContract;
use Modules\Tour\Contracts\Services\EssentialInfoContract;
use Modules\Tour\Contracts\Services\ItineraryContract;
use Modules\Tour\Contracts\Services\LocationContract;
use Modules\Tour\Contracts\Services\QuoteContract;
use Modules\Tour\Contracts\Services\SearchContract;
use Modules\Tour\Contracts\Services\TourContract;
use Modules\Tour\Contracts\Services\TravelStyleContract;
use Modules\Tour\Contracts\Services\VideoContract;
use Modules\Tour\Repositories\AccommodationAmenityRepository;
use Modules\Tour\Repositories\AccommodationRepository;
use Modules\Tour\Repositories\CabinDeckRepository;
use Modules\Tour\Repositories\CityRepository;
use Modules\Tour\Repositories\CountryRepository;
use Modules\Tour\Repositories\DepartureDateRepository;
use Modules\Tour\Repositories\DestinationRepository;
use Modules\Tour\Repositories\EssentialInfoRepository;
use Modules\Tour\Repositories\ItineraryRepository;
use Modules\Tour\Repositories\LocationRepository;
use Modules\Tour\Repositories\QuoteRepository;
use Modules\Tour\Repositories\SearchRepository;
use Modules\Tour\Repositories\TourRepository;
use Modules\Tour\Repositories\VideoRepository;
use Modules\Tour\Services\AccommodationAmenityService;
use Modules\Tour\Services\AccommodationService;
use Modules\Tour\Services\CabinDeckService;
use Modules\Tour\Services\CityService;
use Modules\Tour\Services\CountryService;
use Modules\Tour\Services\DepartureDateService;
use Modules\Tour\Services\DestinationService;
use Modules\Tour\Repositories\TravelStyleRepository;
use Modules\Tour\Services\EssentialInfoService;
use Modules\Tour\Services\ItineraryService;
use Modules\Tour\Services\LocationService;
use Modules\Tour\Services\QuoteService;
use Modules\Tour\Services\SearchService;
use Modules\Tour\Services\TourService;
use Modules\Tour\Services\TravelStyleService;
use Modules\Tour\Services\VideoService;

class TourServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Tour';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'tour';

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
        //        Services
        $this->app->bind(DestinationContract::class, DestinationService::class);
        $this->app->bind(TravelStyleContract::class, TravelStyleService::class);
        $this->app->bind(CityContract::class, CityService::class);
        $this->app->bind(TourContract::class, TourService::class);
        $this->app->bind(AccommodationAmenityContract::class, AccommodationAmenityService::class);
        $this->app->bind(AccommodationContract::class, AccommodationService::class);
        $this->app->bind(EssentialInfoContract::class, EssentialInfoService::class);
        $this->app->bind(DepartureDateContract::class, DepartureDateService::class);
        $this->app->bind(ItineraryContract::class, ItineraryService::class);
        $this->app->bind(LocationContract::class, LocationService::class);
        $this->app->bind(VideoContract::class, VideoService::class);
        $this->app->bind(CabinDeckContract::class, CabinDeckService::class);
        $this->app->bind(QuoteContract::class, QuoteService::class);
        $this->app->bind(SearchContract::class, SearchService::class);
        $this->app->bind(CountryContract::class, CountryService::class);


//        Repositories
        $this->app->bind(DestinationRepositoryContract::class, DestinationRepository::class);
        $this->app->bind(TravelStyleRepositoryContract::class, TravelStyleRepository::class);
        $this->app->bind(CityRepositoryContract::class, CityRepository::class);
        $this->app->bind(AccommodationAmenityRepositoryContract::class, AccommodationAmenityRepository::class);
        $this->app->bind(AccommodationRepositoryContract::class, AccommodationRepository::class);
        $this->app->bind(DepartureDateRepositoryContract::class, DepartureDateRepository::class);
        $this->app->bind(EssentialInfoRepositoryContract::class, EssentialInfoRepository::class);
        $this->app->bind(ItineraryRepositoryContract::class, ItineraryRepository::class);
        $this->app->bind(LocationRepositoryContract::class, LocationRepository::class);
        $this->app->bind(TourRepositoryContract::class, TourRepository::class);
        $this->app->bind(VideoRepositoryContract::class, VideoRepository::class);
        $this->app->bind(CabinDeckRepositoryContract::class, CabinDeckRepository::class);
        $this->app->bind(QuoteRepositoryContract::class, QuoteRepository::class);
        $this->app->bind(CountryRepositoryContract::class, CountryRepository::class);
        $this->app->bind(SearchRepositoryContract::class, SearchRepository::class);

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

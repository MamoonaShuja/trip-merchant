<?php
namespace Modules\SupplierApi\Contracts\Services;

use Illuminate\Contracts\Container\Container;
use Modules\SupplierApi\DataTransfer\ApiTourDTO;
use Modules\SupplierApi\Entities\ApiSupplier;
use Modules\Tour\Entities\Tour;

interface ApiTourContract
{
    /**
     * @param Container $container
     * @return void
     */
    public function initializeContainers(Container $container):void;

    /**
     * @param ApiSupplier $objApiSupplier
     * @param ApiTourDTO $objAp
     * @return void
     */
    public function saveTour(ApiSupplier $objApiSupplier , ApiTourDTO $objAp , Container $container):void;


    /**
     * @param Tour $objTour
     * @param array $galleryFiles
     * @return void
     */
    public function saveGallery(Tour $objTour , array $galleryFiles):void;

    /**
     * @param Tour $objTour
     * @param array $sliderFiles
     * @return void
     */
    public function saveSlider(Tour $objTour , array $sliderFiles):void;
}

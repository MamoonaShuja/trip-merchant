<?php

namespace Modules\Tour\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Tour\DataTransfer\Requests\TourDTO;
use Modules\Tour\Entities\Destination;
use Modules\Tour\Entities\Tour;
use Modules\User\Entities\User;

interface TourContract
{

    /**
     * @param User $objUser
     * @param TourDTO $objTourDTO
     * @return Tour
     */
    public function create(User $objUser, TourDTO $objTourDTO): Tour;

    /**
     * @return Collection
     */
    public function get(User|null $objUser): LengthAwarePaginator|null;


    /**
     * @param User|null $objUser
     * @return LengthAwarePaginator|null
     */
    public function getWithDeals(User|null $objUser): LengthAwarePaginator|null;

    /**
     * @return LengthAwarePaginator|null
     */
    public function getDeleted(): LengthAwarePaginator|null;

    /**
     * @param string $id
     * @return Tour|null
     */
    public function findByUuid(string $id): Tour|null;

    /**
     * @param string|null $strSlug
     * @return Tour|null
     */
    public function findBySlug(string|null $strSlug): Tour|null;

    /**
     * @param Tour $tour
     * @return bool|null
     */
    public function delete(Tour $tour): ?bool;


    /**
     * @param Tour $objTour
     * @param TourDTO $tourDTO
     * @return Tour
     */
    public function update(Tour $objTour, TourDTO $tourDTO): Tour;

    /**
     * @param Tour $objTour
     * @param array $galleryFiles
     * @return void
     */
    public function saveGallery(Tour $objTour, array $galleryFiles): void;

    /**
     * @param Tour $objTour
     * @param array $sliderFiles
     * @return void
     */
    public function saveSlider(Tour $objTour, array $sliderFiles): void;

}

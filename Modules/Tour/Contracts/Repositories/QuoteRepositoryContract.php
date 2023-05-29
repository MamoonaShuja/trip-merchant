<?php

namespace Modules\Tour\Contracts\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourQuote;
use Modules\User\Entities\User;

interface QuoteRepositoryContract
{

    /**
     * @param string $name
     * @return mixed
     */
    public function create(
        User|Auth   $objUser,
        Tour   $objTour,
        City $objCity ,
        string   $strPassengerNumber,
        string   $strDate,
        string   $strDescription,
    );

    /**
     * @return Collection|null
     */
    public function getQuotes(): Collection|null;

    /**
     * @param string $id
     * @return TourQuote|null
     */
    public function findById(string $id): TourQuote|null;

    /**
     * @param string $id
     * @return TourQuote|null
     */
    public function findByUuid(string $id): TourQuote|null;

    /**
     * @param TourQuote $city
     * @return bool
     */
    public function deleteTourQuote(TourQuote $city): bool;

    /**
     * @param TourQuote $objTourQuote
     * @param string|null $strName
     * @return TourQuote
     */
    public function updateTourQuote(
        TourQuote $objTourQuote,
        null|string $strStatus = null,
        null|string $strNote = null,
    ): TourQuote;
}

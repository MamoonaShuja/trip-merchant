<?php

namespace Modules\Tour\Contracts\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\Tour\DataTransfer\Requests\TourQuoteDTO;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourQuote;
use Modules\User\Entities\User;

interface QuoteContract
{
    /**
     * @param TourQuoteDTO $cityCreateDTO
     * @return TourQuote
     */
    public function create(User|Auth $user , Tour $objTour , City $objCity , TourQuoteDTO $tourQuoteDTO): TourQuote;

    /**
     * @return Collection
     */
    public function get() :Collection;

    /**
     * @param string $id
     * @return TourQuote|null
     */
    public function findById(string $id): ?TourQuote;

    /**
     * @param string $id
     * @return TourQuote|null
     */
    public function findByUuid(string $id): TourQuote|null;

    /**
     * @param TourQuote $city
     * @return bool|null
     */
    public function delete(TourQuote $city): ?bool;


    /**
     * @param TourQuote $objTourQuote
     * @param TourQuoteDTO $updateTourQuoteDTO
     * @return TourQuote
     */
    public function update(TourQuote $objTourQuote , TourQuoteDTO $updateTourQuoteDTO): TourQuote;

}

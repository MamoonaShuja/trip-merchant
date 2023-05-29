<?php

namespace Modules\Tour\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\Tour\Contracts\Repositories\QuoteRepositoryContract;
use Modules\Tour\Contracts\Services\QuoteContract;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Tour;
use Modules\Tour\Entities\TourQuote;
use Modules\Tour\DataTransfer\Requests\TourQuoteDTO;
use Modules\User\Entities\User;

class QuoteService implements QuoteContract
{
    public function __construct(
        //Repositories
        private readonly QuoteRepositoryContract $objTourQuoteRepository,
    ) {}

    /**
     * @param TourQuoteDTO $createTourQuoteDTO
     * @return TourQuote
     */
    public function create(User|Auth $objUser , Tour $objTour , City $objCity , TourQuoteDTO $tourQuoteDTO): TourQuote
    {
        return $this->objTourQuoteRepository->create(
            $objUser,
            $objTour,
            $objCity,
            $tourQuoteDTO->getPassengerNumber(),
            $tourQuoteDTO->getDate(),
            $tourQuoteDTO->getDescription(),
        );

    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->objTourQuoteRepository->getQuotes();
    }

    /**
     * @param string $id
     * @return TourQuote|null
     */
    public function findById(string $id): TourQuote|null
    {
        return $this->objTourQuoteRepository->findById($id);
    }

    public function findByUuid(string $id): TourQuote|null
    {
        return $this->objTourQuoteRepository->findByUuid($id);
    }

    public function delete(TourQuote $tourQuote): bool|null
    {
        return $this->objTourQuoteRepository->deleteTourQuote($tourQuote);
    }

    /**
     * @param TourQuote $objTourQuote
     * @param TourQuoteDTO $updateTourQuoteDTO
     * @return TourQuote
     */
    public function update(TourQuote $objTourQuote, TourQuoteDTO $updateTourQuoteDTO): TourQuote
    {
        return $this->objTourQuoteRepository->updateTourQuote(
            $objTourQuote,
            $updateTourQuoteDTO->getStatus(),
            $updateTourQuoteDTO->getNotes(),
        );
    }

}

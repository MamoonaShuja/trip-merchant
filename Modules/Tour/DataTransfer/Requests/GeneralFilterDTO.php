<?php

namespace Modules\Tour\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

class GeneralFilterDTO implements DTO
{
    /**
     * @param string $name
     */
    public function __construct(
        private readonly string|null $name,
        private readonly string|null $destination_id,
        private readonly string|null $date,
        private readonly string|null $city_id,
        private readonly string|null $country_id,
        private readonly string|null $travel_style_id,
        private readonly string|null $supplier_id,
        private readonly string|null $start_date,
        private readonly string|null $end_date,
        private readonly string|null $start_price,
        private readonly string|null $end_price,
    )
    {
    }

    /**
     * @param string $name
     * @return static
     */
    public static function create(string|null $name,
                                  string|null $destination_id,
                                  string|null $date,
                                  string|null $city_id,
                                  string|null $country_id,
                                  string|null $travel_style_id,
                                  string|null $supplier_id,
                                  string|null $start_date,
                                  string|null $end_date,
                                  string|null $start_price,
                                  string|null $end_price): self
    {
        return new self($name, $destination_id, $date, $city_id, $country_id, $travel_style_id, $supplier_id, $start_date, $end_date, $start_price, $end_price);
    }

    /**
     * @return string
     */
    public function getName(): string|null
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCountryId(): string|null
    {
        return $this->country_id;
    }

    /**
     * @return string
     */
    public function getDestinationId(): string|null
    {
        return $this->destination_id;
    }

    /**
     * @return string
     */
    public function getCityId(): string|null
    {
        return $this->city_id;
    }

    /**
     * @return string
     */
    public function getDate(): string|null
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getTravelStyleId(): string|null
    {
        return $this->travel_style_id;
    }

    /**
     * @return string|null
     */
    public function getSupplierId(): string|null
    {
        return $this->supplier_id;
    }

    /**
     * @return string|null
     */
    public function getStartDate(): string|null
    {
        return $this->start_date;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): string|null
    {
        return $this->end_date;
    }

    /**
     * @return string|null
     */
    public function getStartPrice(): string|null
    {
        return $this->start_price;
    }

    /**
     * @return string|null
     */
    public function getEndPrice(): string|null
    {
        return $this->end_price;
    }

}

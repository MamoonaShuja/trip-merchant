<?php

namespace Modules\Tour\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

class CountryDTO implements DTO
{
    /**
     * @param string $name
     */
    public function __construct(
        private readonly string $name,
        private readonly string $destination,
    ) {}

    /**
     * @param string $name
     * @return static
     */
    public static function create(string $name , string $destination): self
    {
        return new self($name , $destination);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

}

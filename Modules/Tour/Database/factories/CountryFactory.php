<?php

namespace Modules\Tour\Database\factories;

use Illuminate\Support\Str;
use Modules\Tour\Entities\Country;
use Modules\Tour\Entities\Destination;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws BindingResolutionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->unique()->country,
            "country_uuid" => Str::uuid(),
            "destination_id" => Destination::inRandomOrder()->take(1)->first()->id
        ];
    }

}


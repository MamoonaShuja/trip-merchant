<?php
namespace Modules\Tour\Database\factories;


use Illuminate\Support\Str;
use Modules\Tour\Entities\City;
use Modules\Tour\Entities\Country;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = City::class;

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

            "name" => $this->faker->unique()->city,
            "city_uuid" => Str::uuid(),
            "country_id" => Country::inRandomOrder()->take(1)->first()->id
        ];
    }

}


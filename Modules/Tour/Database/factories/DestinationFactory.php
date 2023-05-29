<?php
namespace Modules\Tour\Database\factories;

use Illuminate\Support\Str;
use Modules\Tour\Entities\Destination;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;

class DestinationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Destination::class;

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
            "name" => $this->faker->country,
            "destination_uuid" => Str::uuid(),
            "content" => $this->faker->paragraph(8)
        ];
    }

}


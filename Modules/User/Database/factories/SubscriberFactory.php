<?php

namespace Modules\User\Database\factories;

use Illuminate\Support\Str;
use Modules\User\Entities\Subscriber;
use Modules\User\Entities\User;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;

class SubscriberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscriber::class;

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
            "email" => fake()->email(),
            "organizer_id" => User::inRandomOrder()->first()->id,
            "subscriber_uuid" => Str::uuid(),
       ];
    }

}


<?php

namespace Modules\User\Database\factories;

use Modules\Core\Entities\Role;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;
use Illuminate\Support\Facades\Hash;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

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
            "first_name"=> fake()->firstName(),
            "last_name" => fake()->lastName(),
            "email" => fake()->email(),
            "organization_name" => fake()->name(),
            "website" => fake()->url(),
            "message" => fake()->paragraph(),
            "no_of_employees" => fake()->numerify(),
            "code" => fake()->numerify(),
            "organization_code" => fake()->numerify(),
            "password"     => Hash::make("12345678"),
            "role_id"    => Role::inRandomOrder()->take(1)->first()->id
        ];
    }

    public function admin(): UserFactory
    {
        return $this->state(fn() => [
            "user_type"    => UserType::ADMIN->value
        ]);
    }
}


<?php


use Modules\Tour\Entities\Tour;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;

class TourReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Tour\Entities\TourReview::class;

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
        ];
    }

}


<?php

namespace Modules\Tour\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class TourRepositoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function delete(){

    }
}

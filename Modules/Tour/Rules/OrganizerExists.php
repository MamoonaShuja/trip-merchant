<?php

namespace Modules\Tour\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\User\Entities\User;
use Modules\User\Enum\UserType;

class OrganizerExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return User::whereUserUuid($value)
            ->whereHas('role', function ($query) {
                $query->where('name', UserType::ORGANIZER->value);
            })
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The organization does not exist.';
    }
}

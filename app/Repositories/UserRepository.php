<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * User $user
     */
    private User $user;

    /**
     * UserRepository constructor method
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handles creating a user model
     */
    public function create(array $payload): User
    {
        return $this->user->create($payload);
    }
}

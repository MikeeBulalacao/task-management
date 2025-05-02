<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @var User $user
     */
    private User $user;

    /**
     * UserRepository constructor method
     * 
     * @param User $user
     * 
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handles creating a user model
     * 
     * @param array $payload
     * 
     * @return User
     */
    public function create(array $payload): User
    {
        return $this->user->create($payload);
    }
}

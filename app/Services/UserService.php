<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    /**
     * UserRepository $userRepository
     */
    private UserRepository $userRepository;

    /**
     * UserService constructor method
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handles creating a user
     */
    public function create(array $payload): User
    {
        return $this->userRepository->create($payload);
    }
}

<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    /**
     * @var UserRepository $userRepository
     */
    private UserRepository $userRepository;

    /**
     * UserService constructor method
     * 
     * @param UserRepository $userRepository
     * 
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handles creating a user
     * 
     * @param array $payload
     * 
     * @return User
     */
    public function create(array $payload): User
    {
        return $this->userRepository->create($payload);
    }
}

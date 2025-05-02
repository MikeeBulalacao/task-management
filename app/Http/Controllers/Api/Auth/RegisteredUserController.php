<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * @var UserService $userService
     */
    private UserService $userService;

    /**
     * RegisteredUserController constructor method
     * 
     * @var UserService $userService
     * 
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming registration request.
     * 
     * @param RegisterRequest $request
     * 
     * @return JsonResponse
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        $payload = $request->validated();
        $payload = $this->encryptPassword($request->validated());

        $user = $this->userService->create($payload);
        $this->logUserIn($user);

        return $this->response(
            new UserResource($user),
            Response::HTTP_CREATED,
            'Successfully created user.'
        );
    }

    /**
     * In charge of returning the JsonResponse
     * 
     * @param object $resource
     * @param int $status
     * @param string $message
     * 
     * @return JsonResponse
     */
    private function response(
        object $resource,
        int $status = Response::HTTP_OK,
        string $message = 'Success'
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $resource,
        ]);
    }

    /**
     * Handles encrypting the password of the users
     * 
     * @param array $payload
     * 
     * @return array
     */
    private function encryptPassword(array $payload)
    {
        $payload['password'] = Hash::make($payload['password']);

        return $payload;
    }

    /**
     * Logs user in
     * 
     * @var User $user
     *
     * @return void
     */
    private function logUserIn(User $user): void
    {
        Auth::login($user);
    }
}

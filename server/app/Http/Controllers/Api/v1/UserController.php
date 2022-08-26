<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Repositories\UserSessionTokenRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class UserController
{
    public UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function user(int $id): UserResource
    {
        if (!$user = $this->userRepository->byId($id)) {
            abort(404);
        }

        return new UserResource($user);
    }

    public function update(int $id, Request $request): UserResource
    {
        $data = $request->validate([
            'firstname' => ['required', 'max:255'],
            'lastname' => ['required', 'max:255'],
            'username' => ['required', 'max:255', 'unique:users,username'],
            'email' => ['required' , 'email', 'unique:users,email'],
            'mobile' => ['nullable']
        ]);

        if (!$user = $this->userRepository->byId($id)) {
            abort(404);
        }

        $user = $this->userRepository->update($user, $data);
        return new UserResource($user);
    }

    public function delete(int $id): Response|Application|ResponseFactory
    {
        if (!$user = $this->userRepository->byId($id)) {
            abort(404);
        }
        $this->userRepository->delete($user);

        return response([]);
    }

    public function authUser(string $token): UserResource
    {
        $user = $this->userRepository->byToken($token);

        return new UserResource($user);
    }
}

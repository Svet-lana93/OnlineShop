<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\UserEmailVerification;
use App\Http\Resources\UserResource;
use App\Repositories\UserRegistrationRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UserRegistrationController
{
    public UserRegistrationRepository $registrationRepository;

    public function __construct(UserRegistrationRepository $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }

    public function post(Request $request): UserResource
    {

        $data = $request->validate([
            'firstname' => ['required', 'max:255'],
            'lastname' => ['required', 'max:255'],
            'username' => ['required', 'max:255', 'unique:users,username'],
            'mobile' => ['nullable'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required'],
            'passwordRepeat' => ['required', 'same:password']
        ]);

        $user = $this->registrationRepository->post($data);
        UserEmailVerification::dispatch($user);

        return new UserResource($user);
    }

    public function verification(string $token): UserResource
    {
        $user = $this->registrationRepository->findByVerificationToken($token);

        if (!$user) {
            abort(404);
        }
        $this->registrationRepository->setDateOfVerification($user);

        return new UserResource($user);
    }
}

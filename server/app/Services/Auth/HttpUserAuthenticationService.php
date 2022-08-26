<?php

namespace App\Services\Auth;

use App\Repositories\UserRepository;
use App\Repositories\UserSessionTokenRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HttpUserAuthenticationService
{
    private UserRepository $userRepository;
    private Request $request;

    public function __construct(UserRepository $userRepository, Request $request)
    {
        $this->userRepository = $userRepository;
        $this->request = $request;
    }

    public function attempt(): void
    {
        if (!$token = $this->request->bearerToken()) {
            throw new \Exception('Token not provided', 403);
        }

        if (!$user = $this->userRepository->byToken($token)) {
            throw new \Exception('Token is invalid', 403);
        }

        $userContext = new UserContext($user->id, $user->email);

        App::instance(UserContext::class, $userContext);
    }
}

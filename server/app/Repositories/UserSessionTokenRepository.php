<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserSessionToken;
use Illuminate\Support\Str;

class UserSessionTokenRepository
{
    public function createOrUpdate(User $user): UserSessionToken
    {
        $userSessionToken = new UserSessionToken();

        $userSessionToken->updateOrCreate(
            ['user_id' => $user->id],
            ['token' => Str::random(68)],
        );

        return $userSessionToken;
    }

    public function byUserId(int $userId)
    {
        return UserSessionToken::where('user_id', $userId)->first();
    }
}

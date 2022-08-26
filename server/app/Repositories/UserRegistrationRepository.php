<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRegistrationRepository
{
    public function post(array $data): User
    {
        $user = new User();

        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->username = $data['username'];
        $user->mobile = $data['mobile'];
        $user->email = $data['email'];
        $user->email_verification_token = md5(Carbon::now());
        $user->password = Hash::make($data['password']);

        $user->save();
        return $user;
    }

    public function findByVerificationToken(string $token): ?User
    {
        return User::where('email_verification_token', $token)->first();
    }

    public function setDateOfVerification(User $user): User
    {
        $user->email_verified_at = Carbon::now();
        $user->save();

        return $user;
    }
}

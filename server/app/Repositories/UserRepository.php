<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserSessionToken;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function getFiltered(array $filters = []): Collection
    {
        $query = User::query();

        if (!empty($filters['name'])) {
            $query->where(function ($query) use ($filters) {
                $query
                    ->where('firstname', 'like', '%' . $filters['name'] . '%')
                    ->orWhere('lastname', 'like', '%' . $filters['name'] . '%');
            });
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        return $query->get();
    }

    public function byId(int $id): User
    {
        return User::find($id);
    }

    public function update(User $user, array $data): User
    {
        if (isset($data['firstname'])) {
            $user->firstname = $data['firstname'];
        }
        if (isset($data['lastname'])) {
            $user->lastname = $data['lastname'];
        }
        if (isset($data['username'])) {
            $user->username = $data['username'];
        }
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }
        if (isset($data['mobile'])) {
            $user->mobile = $data['mobile'];
        }
        $user->save();
        return $user;
    }

    public function create(array $data): User
    {
        $user = new User();

        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        $user->email_verification_token = md5(Carbon::now());
        $user->password = Hash::make('password');

        $user->save();
        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function byEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function byToken(string $token)
    {
        $token = UserSessionToken::where('token', $token)->first();
        return $token->user;
    }
}

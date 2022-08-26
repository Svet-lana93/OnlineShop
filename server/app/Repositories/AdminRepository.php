<?php

namespace App\Repositories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use MongoDB\BSON\Regex;

class AdminRepository
{
    public function getFiltered(array $filters = []): Collection
    {
        $query = Admin::query();

        if (!empty($filters['name'])) {
            $query->where(function ($query) use ($filters) {
                $query
                    ->where('firstname', 'like', $filters['name'] . '%')
                    ->orWhere('lastname', 'like', $filters['name'] . '%');
            });
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', $filters['email'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    public function byId(int $id): ?Admin
    {
        return Admin::find($id);
    }

    public function update(Admin $admin, array $data): Admin
    {
        if (isset($data['firstname'])) {
            $admin->firstname = $data['firstname'];
        }

        if (isset($data['lastname'])) {
            $admin->lastname = $data['lastname'];
        }

        if (isset($data['email'])) {
            $admin->email = $data['email'];
        }

        if (isset($data['status'])) {
            $admin->status = $data['status'];
        }

        $admin->save();

        return $admin;
    }

    public function delete(Admin $admin): void
    {
        $admin->delete();
    }
}

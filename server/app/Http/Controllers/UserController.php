<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UserController extends Controller
{
    public UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function list(Request $request): Factory|View|Application
    {
        $users = $this->userRepository->getFiltered($request->query->all());

        return view('users.list', ['users' => $users, 'filters' => $request->query->all()]);
    }

    public function edit(int $id): Factory|View|Application
    {
        if (!$user = $this->userRepository->byId($id)) {
            abort(404);
        }

        return view('users.update', ['user' => $user]);
    }

    public function update(int $id, Request $request): Redirector|Application|RedirectResponse
    {
        $data = $request->validate([
            'firstname' => ['required', 'max:255'],
            'lastname' => ['required', 'max:255'],
            'username' => ['required', 'max:255'],
            'email' => ['required' , 'email'],
            'mobile' => ['nullable']
        ]);

        if (!$user = $this->userRepository->byId($id)) {
            abort(404);
        }

        $this->userRepository->update($user, $data);

        return redirect(route('users.list'));
    }

    public function create(): Factory|View|Application
    {
        return view('users.create');
    }

    public function store(Request $request): Redirector|Application|RedirectResponse
    {
        $data = $request->validate([
            'firstname' => ['required', 'max:255'],
            'lastname' => ['required', 'max:255'],
            'username' => ['required', 'max:255', 'unique:users,username'],
            'mobile' => ['nullable'],
            'email' => ['required', 'email', 'unique:users,email']
        ]);

        $this->userRepository->create($data);

        return redirect(route('users.list'));
    }

    public function delete(int $id): Redirector|Application|RedirectResponse
    {
        if (!$user = $this->userRepository->byId($id)) {
            abort(404);
        }
        $this->userRepository->delete($user);

        return redirect(route('users.list'));
    }
}

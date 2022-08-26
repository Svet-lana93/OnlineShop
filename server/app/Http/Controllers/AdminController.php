<?php

namespace App\Http\Controllers;

use App\Events\AdminProfileUpdate;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public AdminRepository $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function list(Request $request): Factory|View|Application
    {
        $admins = $this->adminRepository->getFiltered($request->query->all());

        return view('admins.list', ['admins' => $admins, 'filters' => $request->query->all()]);
    }

    public function admin(int $id): Factory|View|Application
    {
        if (!$admin = $this->adminRepository->byId($id)) {
            abort(404);
        }

        return view('admins.admin', ['admin' => $admin]);
    }

    public function edit(int $id): Factory|View|Application
    {
        if (!$admin = $this->adminRepository->byId($id)) {
            abort(404);
        }

        return view('admins.update', ['admin' => $admin]);
    }

    public function update(Request $request, int $id): Redirector|RedirectResponse
    {
        if (!$admin = $this->adminRepository->byId($id)) {
            abort(404);
        }

        $validationRules = [
            'firstname' => ['required', 'max:255'],
            'lastname' => ['required', 'max:255'],
        ];

        if ($admin->id !== auth()->user()->id) {
            $validationRules = [
                'status' => ['required'],
            ];
        }

        $data = $request->validate($validationRules);

        $admin = $this->adminRepository->update($admin, $data);

        if ($admin->wasChanged('status')) {
            AdminProfileUpdate::dispatch($admin);
        }

        return redirect(route('admins.admin', ['id' => $admin->id]));
    }

    public function delete(int $id): Redirector|RedirectResponse
    {
        if (!$admin = $this->adminRepository->byId($id)) {
            abort(404);
        }

        if (auth()->user() == $admin) {
            abort(403);
        }

        $this->adminRepository->delete($admin);
        AdminProfileUpdate::dispatch($admin);

        return redirect(route('admins.list'));
    }
}

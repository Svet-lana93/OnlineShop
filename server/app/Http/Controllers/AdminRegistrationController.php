<?php

namespace App\Http\Controllers;

use App\Events\AdminProfileUpdate;
use App\Events\AdminEmailVerification;
use App\Repositories\AdminRegistrationRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminRegistrationController extends Controller
{
    public AdminRegistrationRepository $registrationRepository;

    public function __construct(AdminRegistrationRepository $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }

    public function view(): Factory|View|Application
    {
        return view('registration.view');
    }

    public function post(Request $request): Factory|View|Application
    {
        $data = $request->validate([
            'firstname' => ['required', 'max:255'],
            'lastname' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:admins,email'],
            'password' => ['required'],
            'passwordRepeat' => ['required', 'same:password']
        ]);

        $admin = $this->registrationRepository->post($data);
        AdminEmailVerification::dispatch($admin);

        return view('registration.email-verification');
    }

    public function verification(string $token)
    {
        $admin = $this->registrationRepository->findByVerificationToken($token);
        if ($admin) {
            $this->registrationRepository->setDateOfVerification($admin);
            return redirect(route('login-page'));
        } else{
            abort(404);
        }
    }
}

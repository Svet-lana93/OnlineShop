<?php

namespace App\Http\Middleware;

use App\Models\AdminStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (!Auth::guard('admin')->check()) {
            return redirect(route('login-page'));
        }
        $admin = auth()->user();

        if ($admin->email_verified_at === null || AdminStatus::ACTIVE != $admin->status) {
            return response('Email should be verified or status should be changed');
        }

        return $next($request);
    }
}

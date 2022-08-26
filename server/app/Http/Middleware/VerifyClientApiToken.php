<?php

namespace App\Http\Middleware;

use App\Repositories\ClientRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class VerifyClientApiToken
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $apiToken = $request->header('api-token');

        if (!$apiToken || !$this->clientRepository->byApiToken($apiToken)) {
            return response(['error' => 'Client is not verified'], 403);
        }

        return $next($request);
    }
}

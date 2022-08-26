<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository
{
    public function byApiToken(string $apiToken)
    {
        return Client::where('api_token', $apiToken)->first();
    }
}

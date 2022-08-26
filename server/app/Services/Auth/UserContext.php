<?php

namespace App\Services\Auth;

class UserContext
{
    public ?int $userId;
    public ?string $email;

    public function __construct(?int $userId = null, ?string $email = null)
    {
        $this->userId = $userId;
        $this->email = $email;
    }
}

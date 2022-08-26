<?php

namespace App\Http\Resources;

use App\Repositories\UserSessionTokenRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'token' => $this->userSessionTokenRepository()->byUserId($this->id)->token,
        ];
    }

    private function userSessionTokenRepository(): UserSessionTokenRepository
    {
        return app(UserSessionTokenRepository::class);
    }
}

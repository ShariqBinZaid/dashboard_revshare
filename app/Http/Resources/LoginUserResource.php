<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LoginUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $user = Auth::user();
        $token = $user->createToken('MyApp')->accessToken;
        return [
            'user' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'gender' => $this->gender,
                'location' => $this->location,
                'dob' => $this->dob,
                'display_picture' => $this->display_picture ? env('APP_URL').'/storage/'.$this->display_picture : ''
            ],
            'token' => $token
        ];
    }
}

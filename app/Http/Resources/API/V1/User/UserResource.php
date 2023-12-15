<?php

namespace App\Http\Resources\API\V1\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
//            'image' => $this->image ? url("/storage/uploads/users/{$this->id}/profile/{$this->image}") : null,
            "role" => $this->userType($this->role_id),
            "blocked_due" => $this->blocked_due,
            "no_cancellations" => $this->cancellations,
            "created" => $this->created_at->diffForHumans(),
            "updated" => $this->updated_at->diffForHumans(),
            'email_verified_at' => $this->email_verified_at,
        ];
    }

    public function userType(int $type)
    {
        switch ($type) {
            case 1:
                return 'User';
                break;
            case 2:
                return 'Garage Admin';
                break;
            case 3:
                return 'System Admin';
                break;

            default:
                # code...
                break;
        }
    }
}

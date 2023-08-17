<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->fname . ' ' .$this->lname,
            'profile' => $this->profile_img,
            'dob' => Carbon::parse($this->dob)->format('d F Y'),
            'age' => Carbon::parse($this->dob)->age,
            'cnumber' => $this->details->cnumber,
            'email' => $this->user->email,
            'created_at' => Carbon::parse($this->user->created_at)->format('d F Y H:i:s.u'),
            'updated_at' => (! empty($this->updated_at)) ? Carbon::parse($this->updated_at)->format('d F Y H:i:s.u') : null,
            'deleted_at' => (! empty($this->deleted_at)) ? Carbon::parse($this->deleted_at)->format('d F Y H:i:s.u') : null,
            'role' => [
                'id' => $this->user->role_id,
                'name' => $this->user->roles->role_name ?? null,
            ],
        ];
    }
}

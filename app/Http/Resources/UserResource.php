<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user_id,
            'name' => $this->details->fname . ' ' .$this->details->lname,
            'profile' => $this->details->profile_img ?? null,
            'dob' => Carbon::parse($this->details->dob)->format('d F Y'),
            'age' => Carbon::parse($this->details->dob)->age,
            'cnumber' => $this->details->cnumber,
            'email' => $this->email,
            'created_at' => Carbon::parse($this->created_at)->format('d F Y H:i:s.u'),
            'updated_at' => (! empty($this->updated_at)) ? Carbon::parse($this->updated_at)->format('d F Y H:i:s.u') : null,
            'deleted_at' => (! empty($this->deleted_at)) ? Carbon::parse($this->deleted_at)->format('d F Y H:i:s.u') : null,
            'role' => [
                'id' => $this->role_id,
                'name' => $this->roles->role_name ?? null,
            ],
        ];
    }
}

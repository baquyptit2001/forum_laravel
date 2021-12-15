<?php

namespace App\Http\Resources;

use Facade\FlareClient\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class UserResource extends JsonResource
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
            'name' => $this->profile->display_name,
            'email' => $this->email,
            'avatar' => env('APP_URL') . $this->profile->avatar,
            'description' => $this->profile->description ?? "Chưa có mô tả",
            'since' => $this->created_at->diffForHumans(),
        ];
    }
}

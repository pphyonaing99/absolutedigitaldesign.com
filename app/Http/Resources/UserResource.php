<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
       /* $role_info = $this->role;
       return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $email,
            'role_name' => $role_info->name,
        ];*/
    }
}

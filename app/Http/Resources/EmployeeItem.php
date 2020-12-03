<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'fname' => $this->fname,
            'lname' => $this->lname,
            'email' => $this->email,
            'company' => $this->company_id,
            'email' => $this->email,
            'phone' => $this->phone
        ];
    }
}

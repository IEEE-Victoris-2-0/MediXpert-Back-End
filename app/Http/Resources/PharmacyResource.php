<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PharmacyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pharmacy_name'=>$this->pharmacy_name,
            'pharmacy_address'=>$this->pharmacy_address,
            'pharmacy_image'=>$this->pharmacy_image,
            'pharmacy_phone'=>$this->pharmacy_phone
        ];
    }
}

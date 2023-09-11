<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DrugResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'drugname'=>$this->drug_name,
            'description'=>$this->description,
            'drug_image'=>$this->drug_image,
            'item_price'=>$this->item_price,
            'qty'=>$this->qty,
            'category_id'=>$this->category_id,
            //'drugname'=>$this->drug_name,
        ];
    }
}

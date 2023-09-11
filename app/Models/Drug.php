<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Pharmacy;

class Drug extends Model
{
    use HasFactory;

    protected $fillable = [
        'drug_name',
        'description',
        'drug_image' ,
        'item_price',
        'qty',
        'category_id',
        'pharmacy_id'
    ];
    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function Pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
}

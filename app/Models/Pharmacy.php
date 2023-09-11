<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Drug;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'pharmacy_name',
        'pharmacy_address',
        'pharmacy_image',
        'pharmacy_phone',
    ];


    public function Drug()
    {
        return $this->hasMany(Drug::class);
    }
}

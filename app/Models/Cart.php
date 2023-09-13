<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Drug;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'user_id',
        'drug_id',
        'qty'
    ];


    public function drug()
    {
        return $this->belongsTo(Drug::class,'drug_id','id');
    }
}

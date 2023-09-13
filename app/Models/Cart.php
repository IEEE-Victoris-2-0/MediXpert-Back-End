<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Drug;
use App\Models\User;
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
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}

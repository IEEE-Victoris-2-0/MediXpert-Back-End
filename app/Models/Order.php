<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'fname',
        'lname',
        'phone',
        'address',
        'state',
        'city',
        'total_price',
        'tracking_no',
    ];

    public function OrderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

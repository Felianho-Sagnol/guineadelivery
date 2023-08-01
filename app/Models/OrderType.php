<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class,'order_type_id','id');
    }
}

<?php

namespace App\Models;

use App\Models\Dish;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Category;
use App\Models\OrderType;
use App\Models\PaymentMode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];


    public function categories()
    {
        return $this->hasMany(Category::class,'restaurant_id','id')->with('dishes');
    }

    public function dishes()
    {
        return $this->hasMany(Dish::class,'restaurant_id','id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'restaurant_id','id');
    }

    public function order_types()
    {
        return $this->hasMany(OrderType::class,'restaurant_id','id');
    }

    public function payment_modes()
    {
        return $this->hasMany(PaymentMode::class,'restaurant_id','id');
    }

    public function admins()
    {
        return $this->hasMany(Admin::class,'restaurant_id','id');
    }
}

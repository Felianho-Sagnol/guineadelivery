<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderDish;
use App\Models\OrderType;
use App\Models\Restaurant;
use App\Models\PaymentMode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function dishes(){
        return $this->hasMany(OrderDish::class,'order_id','id')->with('category');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function oder_type(){
        return $this->belongsTo(OrderType::class);
    }

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function payement_mode(){
        return $this->belongsTo(PaymentMode::class);
    }

    // public function dishes(){
    //     return $this->hasMany(Dish::class,'order_id','id');
    // }
}

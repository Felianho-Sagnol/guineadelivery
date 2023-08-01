<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
}

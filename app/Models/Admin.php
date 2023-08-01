<?php

namespace App\Models;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
}

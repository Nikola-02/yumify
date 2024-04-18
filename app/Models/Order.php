<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'is_ordered', 'ordered_on_location'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderLines(){
        return $this->hasMany(OrderLine::class);
    }
}

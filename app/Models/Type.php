<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function meals(){
        return $this->hasMany(Meal::class);
    }

    public function restaurants(){
        return $this->belongsToMany(Restaurant::class);
    }
}

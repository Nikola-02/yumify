<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'open_in',
        'close_in',
        'image'
    ];

    public function ratings(){
        return $this->hasMany(Rating::class, 'restaurant_id');
    }

    public function meals(){
        return $this->hasMany(Meal::class);
    }

    public function types(){
        return $this->belongsToMany(Type::class);
    }

    public function benefits(){
        return $this->belongsToMany(Benefit::class);
    }
}

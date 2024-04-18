<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'restaurant_id',
        'type_id'
    ];

    protected $appends = ['latestPrice'];

    public function orderLines(){
        return $this->hasMany(OrderLine::class);
    }

    public function prices(){
        return $this->hasMany(Price::class);
    }

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function getLatestPriceAttribute(){
        return $this->prices()->latest()->first();
    }

    public function scopeFilter($builder, array $filters){
        if(isset($filters['search'])){
            $builder->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if(isset($filters['food_type'])){
            if($filters['food_type'])
            $builder->whereIn('type_id', $filters['food_type']);
        }

        if(isset($filters['sort'])){
            if($filters['sort'] == 'price-asc'){
                $builder->orderBy('trigger_price');
            }

            if($filters['sort'] == 'price-desc'){
                $builder->orderByDesc('trigger_price');
            }

            if($filters['sort'] == 'name-asc'){
                $builder->orderBy('name');
            }

            if($filters['sort'] == 'name-desc'){
                $builder->orderByDesc('name');
            }
        }
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = ['name', 'price', 'image', 'food_category_id'];

    public function foodCategory()
    {
        return $this->belongsTo(FoodCategory::class);
    }
}


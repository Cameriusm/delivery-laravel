<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $fillable=['creator_id', 'restaurant_id',];

    public function restaurant()
    {
        return $this->belongsTo(Restaurants::class);
    }

    public function orders()
    {
        return $this->hasMany(Bills::class);
    }
}

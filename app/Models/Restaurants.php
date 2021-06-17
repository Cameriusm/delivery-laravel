<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Orders;


class Restaurants extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['user_id','href', 'updated_at','name', 'phone_number'];

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
public function CreateOrder(Request $request){
        $new_order = Orders::updateOrCreate([
        'creator_id' => $user_id,
        'restaurant_id' => $new_res->id
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function create(Request $request)
    {

        $user_id = $request->user_id;
        $order_id = $request->order_id;
        $products = $request->products;

//dd($request->all());
        // product : {name: 'test', quantity: '34', cost: '33'}

        foreach ($products as $product) {
            print_r($product['name']);
        }

        dd([
            '123' => $user_id,
            '$order_id' => $order_id,
            'lool' => $products

        ]);
        //$price = Bills::updateOrCreate({
        //     'price' => $price;
        // });

    }
}

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
         $product = ['name' => 123,
             'quantity' => 2222,
             'price' => 99999999];


        foreach ($products as $product) {
            print_r($product['name']);
        }

//        dd([
//            '123' => $user_id,
//            '$order_id' => $order_id,
//            'lool' => $products
//
//        ]);
        //$price = Bills::updateOrCreate({
        //     'price' => $price;
        // });

    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Restaurants;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use const http\Client\Curl\Versions\CURL;

class RestaurantController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getUrl(Request $request)
    {

        // $date = Carbon::today()->format('Y-M-D');
        // dd($date);

        $res_href = $request->href;
        $user_id = $request->user_id;

//        dd(['res_href'=> $res_href,'user_id'=> $user_id]);

        $new_res = Restaurants::updateOrCreate([
            'user_id' => $user_id,
            'href' => $res_href,
            'name' => 'SOS'

        ]);


        $new_order = Orders::create([
            'creator_id' => $user_id,
           'restaurant_id' => $new_res->id
        ]);

       // dd($new_order);

//        dd($new_res);

//        print_r($new_res);

//        dd($request->href);


        return response()->json([
            'new_res' => $new_res,
            'message' => 'Success',
        ]);
    }

    public function create(Request $request)
    {


        $user_id = $request->user_id;


        $res = Restaurants::where('user_id', $user_id)->firstOrFail();


//        dd($res);

        return response()->json([
            'user_id' => $res->user_id,
            'href' => $res->href,
        ]);
    }


    public function list(Request $request)
    {
        // TODO: Получить все рестораны которые были добавлены сегодня
        // TODO: Сделать запрос к парсеру для получения более подробной информации
        // TODO: Сгенерировать коллекцию полноценных ресторанов включаеющих доп информацию (картинка, описание и т.д)
        // TODO: Отправить пользователю запрашивающему коллекцию на Vue
        // TODO : Vue -> Laravel -> Nodejs -> Laravel -> Vue

        $orders_raw = Orders::whereDate('updated_at', Carbon::today())->get();

        // dd($orders_raw);


        $orders = $orders_raw->map(function ($order_raw) {

            $infoRaw = Curl::to(env('SCRAPER_URL') . '/api/parse')
                ->withData(array('href' => $order_raw->restaurant->href))
                ->withContentType("application/x-www-form-urlencoded")
                ->post();


            $info = json_decode($infoRaw);
            $order_owner = User::where('id', $order_raw->restaurant->user_id)->firstOrFail();

           // dd($order_owner);

            //dd($info);

            if ($info) {
                $order_raw->menu = $info->menu;
                $order_raw->name = $info->name;
                $order_raw->owner = [
                    'name' => $order_owner->first_name,
                    'second'=>$order_owner->second_name,
                    'phone'=>$order_owner->phone_number

                ];

                //Добавить авубомбу $order_raw->avatar = $info->restaurant->avatar;
            } else {
                $order_raw->menu = null;
                $order_raw->name = null;
                return response()->json(['collection' => $orders,
                'status'=>':( slomalsya'
                ]);
            }

        });

//        dd($restaurants_raw);


        return response()->json(['collection' => $orders]);


    }

    public function parsing(Request $request)
    {
        $response = Curl::to(env('SCRAPER_URL') . '/api/parse')
            ->withData(array('url' => $request->href))
            ->withContentType("application/x-www-form-urlencoded")
            ->post();
        return response()->json($response);
    }

    function update(Request $request, Restaurants $restaurants)
    {

        //dd($request->all());
        $restaurants->update(array_merge($request->all(), ['updated_at' => Carbon::now()]));
    }

}

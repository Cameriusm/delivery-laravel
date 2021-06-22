<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Restaurants;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ixudra\Curl\Facades\Curl;
use const http\Client\Curl\Versions\CURL;

class RestaurantController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        dd(Auth::user());
        $res_href = $request->href;
        $user_id = Auth::user()->id;


        $new_res = Restaurants::updateOrCreate([
            'user_id' => $user_id,
            'href' => $res_href,


        ]);

        $new_order = Orders::create([
            'creator_id' => $user_id,
            'restaurant_id' => $new_res->id
        ]);

        return response()->json([
            'new_res' => $new_res,
            'user_id' => $user_id,
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



        $orders = [];

        foreach ($orders_raw as $order_raw) {

            $infoRaw = Curl::to(env('SCRAPER_URL') . '/api/parse')
                ->withData(array('href' => $order_raw->restaurant->href))
                ->withContentType("application/x-www-form-urlencoded")
                ->post();
            $info = json_decode($infoRaw);




            $order_owner = User::where('id', $order_raw->restaurant->user_id)->firstOrFail();

            $order_raw->restaurant->owner = [
                'name' => $order_owner->first_name,
                'second' => $order_owner->second_name,
                'phone' => $order_owner->phone_number
            ];

            if ($info) {
                $order_raw->restaurant->menu = $info->menu;
                $order_raw->restaurant->name = $info->name;
            } else {
                $order_raw->restaurant->menu = null;
                $order_raw->restaurant->name = null;
            }



            array_push($orders, $order_raw);
        }

        if (count($orders)) {
            return response()->json([
                'collection' => $orders,
                'mesage' => 'Success'
            ]);
        } else {
            return response()->json([
                'collection' => $orders,
                'mesage' => 'Error'
            ]);
        }
    }

    public function parse(Request $request)
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

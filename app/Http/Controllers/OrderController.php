<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $customerOrders = $request->all();

        $products = Product::whereIn('id', array_keys($customerOrders))->get();
        $orders = [];
        foreach ($products as $product) {
            foreach ($product->stores as $store) {
                if ($customerOrders[$product->id] <= $store->pivot->count && !isset($orders[$product->id]['count'])) {
                    $orders[$product->id][$store->id] = $customerOrders[$product->id];
                    $store->pivot->decrement('count', $customerOrders[$product->id]);
                    $product->decrement('count', $customerOrders[$product->id]);
                    $order = new Order();
                    $order->product_id = $product->id;
                    $order->store_id = $store->id;
                    $order->count = $customerOrders[$product->id];
                    $order->save();
                    break;
                }elseif ($store->pivot->count != 0) {
                    if (!isset($orders[$product->id]['count'])) {
                        $orders[$product->id]['count'] = 0;
                    }

                    if ($customerOrders[$product->id] - $orders[$product->id]['count'] < $store->pivot->count) {
                        $count = $customerOrders[$product->id] - $orders[$product->id]['count'];
                        $orders[$product->id]['count'] += $count;
                        $store->pivot->decrement('count', $count);
                        $product->decrement('count', $count);
                        $order = new Order();
                        $order->product_id = $product->id;
                        $order->store_id = $store->id;
                        $order->count = $count;
                        $order->save();
                        continue;
                    }

                    $orders[$product->id]['count'] += $store->pivot->count;
                    $store->pivot->decrement('count', $store->pivot->count);
                    $product->decrement('count', $store->pivot->count);
                    $order = new Order();
                    $order->product_id = $product->id;
                    $order->store_id = $store->id;
                    $order->count = $store->pivot->count;
                    $order->save();

                }
            }
        }

        return response()->json(['success' => true], 200);
    }
}

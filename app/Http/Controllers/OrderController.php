<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Jobs\SendOrderCreatedEmail;

class OrderController extends Controller
{
    public function createOrder(CreateOrderRequest $request)
    {
        $user = auth()->user();
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['message' => 'Кошик порожній'], 400);
        }

        $orderId = DB::table('orders')->insertGetId([
            'user_id' => $user->id,
            'payment_method' => $request->payment_method,
            'place' => $request->place,
            'shipping_status' => 'pending'
        ]);

        foreach ($cart as $productId => $item) {
            $watcher = DB::table('watchers')->where('id', $productId)->first();
            if (!$watcher) {
                return response()->json(['message' => 'Товар не знайдено'], 400);
            }

            DB::table('order_items')->insert([
                'order_id' => $orderId,
                'watcher_id' => $watcher->id,
                'quantity' => $item['quantity'],
                'price' => $watcher->price
            ]);
        }

        SendOrderCreatedEmail::dispatch($orderId);

        session()->forget('cart');

        return redirect()->route('profile.profile')->with('success', 'Замовлення створено успішно!');
    }

    public function orderHistory()
    {
        $user = auth()->user();

        $orders = DB::table('orders')
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();

        $ordersWithItems = $orders->map(function ($order) {
            $items = DB::table('order_items')
                ->join('watchers', 'order_items.watcher_id', '=', 'watchers.id')
                ->select('order_items.*', 'watchers.product_name', 'watchers.price', 'watchers.image_url')
                ->where('order_items.order_id', $order->id)
                ->get();

            $order->items = $items;
            return $order;
        });

        return view('order.history', ['orders' => $ordersWithItems]);
    }

    public function index()
    {
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.*',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->orderBy('orders.created_at', 'desc')
            ->get();

        $orders = $orders->map(function ($order) {
            $order->items = DB::table('order_items')
                ->join('watchers', 'order_items.watcher_id', '=', 'watchers.id')
                ->select(
                    'order_items.*',
                    'watchers.product_name',
                    'watchers.price as watcher_price',
                    'watchers.image_url'
                )
                ->where('order_items.order_id', $order->id)
                ->get();

            $order->total_price = $order->items->sum(function($item) {
                return $item->price * $item->quantity;
            });

            return $order;
        });

        return view('admin.orders.index', compact('orders'));
    }

    public function edit($orderId)
    {
        $order = DB::table('orders')->where('id', $orderId)->first();

        if (!$order) {
            abort(404);
        }

        return view('admin.orders.edit', compact('order'));
    }

    public function update(UpdateOrderRequest $request, $orderId)
    {
        DB::table('orders')
            ->where('id', $orderId)
            ->update([
                'shipping_status' => $request->shipping_status,
                'payment_method' => $request->payment_method,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.orders')->with('success', 'Замовлення оновлено.');
    }

    public function destroy($orderId)
    {
        DB::table('order_items')->where('order_id', $orderId)->delete();
        DB::table('orders')->where('id', $orderId)->delete();

        return redirect()->route('admin.orders')->with('success', 'Замовлення видалено.');
    }
}

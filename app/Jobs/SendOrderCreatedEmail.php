<?php

namespace App\Jobs;

use App\Mail\OrderCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendOrderCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $orderId;

    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle(): void
    {
        $order = DB::table('orders')->where('id', $this->orderId)->first();
        if (!$order) return;

        $user = DB::table('users')->where('id', $order->user_id)->first();
        if (!$user) return;

        $items = DB::table('order_items')
            ->join('watchers', 'order_items.watcher_id', '=', 'watchers.id')
            ->select('order_items.*', 'watchers.product_name', 'watchers.price')
            ->where('order_items.order_id', $this->orderId)
            ->get();

        $orderData = [
            'id' => $order->id,
            'payment_method' => $order->payment_method,
            'place' => $order->place,
            'shipping_status' => $order->shipping_status,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'orderItems' => $items->map(function($item) {
                return [
                    'product_name' => $item->product_name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            })->toArray(),
        ];

        Mail::to($user->email)->send(new OrderCreated($orderData));

    }
}

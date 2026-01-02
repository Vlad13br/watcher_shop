<x-app-layout>
    <div class="max-w-6xl mx-auto p-4 bg-gray-100 animate-fadeIn">
        <h2 class="text-2xl font-bold mb-4">Admin - Orders</h2>

        @if(session('success'))
            <div class="mb-4 px-4 py-2 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border border-gray-200 mt-4">
            <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 border-b">Order ID</th>
                <th class="px-4 py-2 border-b">User</th>
                <th class="px-4 py-2 border-b">Total Price</th>
                <th class="px-4 py-2 border-b">Shipping Status</th>
                <th class="px-4 py-2 border-b">Items</th>
                <th class="px-4 py-2 border-b">Edit</th>
                <th class="px-4 py-2 border-b">Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $order->id }}</td>
                    <td class="px-4 py-2 border-b">{{ $order->user_name }}</td>
                    <td class="px-4 py-2 border-b">{{ $order->total_price }} USD</td>
                    <td class="px-4 py-2 border-b">{{ $order->shipping_status }}</td>
                    <td class="px-4 py-2 border-b">
                        <ul>
                            @foreach($order->items as $item)
                                <li>
                                    {{ $item->product_name }} (x{{ $item->quantity }}) - {{ $item->price }} USD
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="px-4 py-2 border-b">
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-blue-500">Edit</a>
                    </td>
                    <td class="px-4 py-2 border-b">
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                              onsubmit="return confirm('Ви впевнені, що хочете видалити це замовлення?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

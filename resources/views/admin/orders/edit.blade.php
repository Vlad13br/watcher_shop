<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-lg animate-fadeIn">
        <h2 class="text-2xl font-semibold mb-6">Edit Order #{{ $order->id }}</h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="shipping_status" class="block mb-1 font-medium">Shipping Status</x-input-label>
                <select name="shipping_status" id="shipping_status" class="w-full border-gray-300 rounded-md p-2">
                    @foreach(['pending' => 'Pending', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'canceled' => 'Canceled'] as $key => $label)
                        <option value="{{ $key }}" {{ $order->shipping_status === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="payment_method" class="block mb-1 font-medium">Payment Method</x-input-label>
                <x-text-input
                    type="text"
                    name="payment_method"
                    id="payment_method"
                    class="w-full border-gray-300 rounded-md p-2"
                    value="{{ old('payment_method', $order->payment_method) }}"
                />
            </div>

            <div>
                <x-input-label class="block mb-1 font-medium">Total Price</x-input-label>
                <input type="text" class="w-full border-gray-300 rounded-md p-2 bg-gray-100"
                       value="{{ number_format($order->total_price ?? 0, 2) }} USD" readonly>
            </div>

            <div>
                <x-blue-button type="submit">Update Order</x-blue-button>
            </div>
        </form>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="flex p-8">
        <div class="w-full sm:w-1/4 bg-white p-6 rounded-lg shadow-lg mr-4">
            <form method="GET" action="{{ route('watcher.index') }}">
                <h2 class="text-lg font-semibold mb-4 text-gray-900">Filters</h2>

                <div class="mb-6">
                    <x-input-label for="min-price" class="block text-sm font-medium text-gray-800">Min Price
                    </x-input-label>
                    <x-text-input id="min-price" name="min_price" type="number" min="0"
                                  class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2"
                                  placeholder="0" value="{{ request('min_price') }}"/>
                </div>

                <div class="mb-6">
                    <x-input-label for="max-price" class="block text-sm font-medium text-gray-800">Max Price
                    </x-input-label>
                    <x-text-input id="max-price" name="max_price" type="number" min="0"
                                  class="mt-1 block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2"
                                  placeholder="1000" value="{{ request('max_price') }}"/>
                </div>

                <div class="mb-6">
                    <x-input-label for="sort" class="block text-sm font-medium text-gray-800">Sort By</x-input-label>
                    <x-select id="sort" name="sort"
                              class="appearance-none block w-full border-2 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-3 bg-white text-gray-800 cursor-pointer"
                              :options="[
        'price-asc' => 'Price: Low to High',
        'price-desc' => 'Price: High to Low',
        'rating' => 'Rating'
    ]"
                              :selected="request('sort')"/>

                </div>

                <div class="flex space-x-4">
                    <x-primary-button type="submit"
                                      class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition-colors duration-200 text-center flex justify-center">
                        Apply
                    </x-primary-button>
                    <a href="{{ route('watcher.index') }}"
                       class="w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition-colors duration-200 text-center flex justify-center">
                        Reset
                    </a>
                </div>
            </form>

        </div>

        <div class="w-full sm:w-3/4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($products as $product)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <a href="{{ route('watch.show', $product->id) }}" class="block">
                        <h3 class="text-xl font-semibold mb-4">{{ $product->product_name }}</h3>
                        <img src="{{ $product->image_url }}" alt="Product Image"
                             class="w-full h-48 object-cover rounded-lg mb-4">
                    </a>
                    <div class="flex items-center mt-2">
                        @php
                            $roundedRating = round($product->rating);
                        @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $roundedRating)
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400"
                                     fill="currentColor"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M10 15.27l-6.18 3.73 1.64-7.03L0 6.24l7.19-.61L10 0l2.81 5.63L20 6.24l-5.46 5.73 1.64 7.03z"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300"
                                     fill="currentColor"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M10 15.27l-6.18 3.73 1.64-7.03L0 6.24l7.19-.61L10 0l2.81 5.63L20 6.24l-5.46 5.73 1.64 7.03z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <div class="flex justify-between items-center mt-2">
                        <div class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</div>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.watchers.edit', $product->id) }}"
                                       class="bg-yellow-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                                        Edit
                                    </a>
                                @else
                                    <x-primary-button
                                        type="button"
                                        class="add-to-cart-btn bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->product_name }}"
                                        data-product-price="{{ $product->price }}"
                                        data-product-image="{{ $product->image_url }}">
                                        Add to Cart
                                    </x-primary-button>

                                @endif
                            @endauth

                            @guest
                                <x-primary-button
                                    type="button"
                                    class="add-to-cart-btn bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->product_name }}"
                                    data-product-price="{{ $product->price }}"
                                    data-product-image="{{ $product->image_url }}">
                                    Add to Cart
                                </x-primary-button>

                            @endguest
                        </form>

                    </div>

                </div>
            @endforeach
            <div class="mt-6 col-span-full flex justify-start">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

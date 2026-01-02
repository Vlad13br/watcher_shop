<x-app-layout>
    <div class="max-w-6xl mx-auto p-4 bg-gray-100 animate-fadeIn">
        @if(session('success'))
            <div class="mb-4 px-4 py-2 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <h2>Створити новий годинник</h2>

        <form action="{{ route('admin.watchers.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <x-input-label for="product_name" class="block text-sm font-medium text-gray-700">Назва продукту</x-input-label>
                    <x-text-input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}" class="mt-1 block w-full px-3 py-2" required />
                    @error('product_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="price" class="block text-sm font-medium text-gray-700">Ціна</x-input-label>
                    <x-text-input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="0.01" class="mt-1 block w-full px-3 py-2" required />
                    @error('price')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="description" class="block text-sm font-medium text-gray-700">Опис</x-input-label>
                    <textarea name="description" id="description" class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="material" class="block text-sm font-medium text-gray-700">Матеріал</x-input-label>
                    <x-text-input type="text" name="material" id="material" value="{{ old('material') }}" class="mt-1 block w-full px-3 py-2" />
                    @error('material')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="brand" class="block text-sm font-medium text-gray-700">Бренд</x-input-label>
                    <x-text-input type="text" name="brand" id="brand" value="{{ old('brand') }}" class="mt-1 block w-full px-3 py-2" />
                    @error('brand')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="stock" class="block text-sm font-medium text-gray-700">Кількість в наявності</x-input-label>
                    <x-text-input type="number" name="stock" id="stock" value="{{ old('stock') }}" min="0" class="mt-1 block w-full px-3 py-2" required />
                    @error('stock')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="image_url" class="block text-sm font-medium text-gray-700">URL зображення</x-input-label>
                    <x-text-input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}" class="mt-1 block w-full px-3 py-2" />
                    @error('image_url')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <x-blue-button>Створити</x-blue-button>
            </div>
        </form>
    </div>
</x-app-layout>

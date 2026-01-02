<x-app-layout>
    <div class="max-w-6xl mx-auto p-4 bg-gray-100 animate-fadeIn">

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.users') }}" class="text-blue-600">Користувачі</a><br>
                <a href="{{ route('admin.orders') }}" class="text-blue-600">Замовлення</a><br>
                <a href="{{ route('admin.watchers.create') }}" class="text-blue-600">Додати новий годинник</a>
            @elseif(auth()->user()->role === 'manager')
                <a href="{{ route('admin.watchers.create') }}" class="text-blue-600">Додати новий годинник</a>
            @endif
        @endauth

    </div>
</x-app-layout>

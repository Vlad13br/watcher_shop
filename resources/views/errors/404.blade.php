<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center">
        <h1 class="text-6xl font-bold text-gray-800">404</h1>
        <p class="text-gray-600 mt-4">Сторінку не знайдено</p>

        <a href="{{ route('watcher.index') }}"
           class="mt-6 px-6 py-2 bg-indigo-600 text-white rounded">
            На головну
        </a>
    </div>
</x-app-layout>

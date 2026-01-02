<x-app-layout>
    <div class="text-center mt-20">
        <h1 class="text-3xl font-bold">Забагато спроб</h1>
        <p>Спробуйте ще через {{ $retryAfter }} секунд.</p>
        <a href="{{ route('login') }}" class="text-blue-500 underline">Повернутися на логін</a>
    </div>
</x-app-layout>

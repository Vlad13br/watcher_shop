<x-app-layout>
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Відновлення пароля</h2>

        @if(session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <x-input-label for="email">Email</x-input-label>
            <x-text-input type="email" name="email" required class="w-full p-2 mb-4"/>
            <x-blue-button>Надіслати посилання</x-blue-button>
        </form>
    </div>
</x-app-layout>

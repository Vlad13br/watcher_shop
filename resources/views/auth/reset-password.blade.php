<x-app-layout>
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Скидання пароля</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <x-input-label for="email">Email</x-input-label>
            <x-text-input type="email" name="email" value="{{ $email ?? old('email') }}" required class="w-full p-2 mb-4"/>

            <x-input-label for="password">Новий пароль</x-input-label>
            <x-text-input type="password" name="password" required class="w-full p-2 mb-4"/>

            <x-input-label for="password_confirmation">Підтвердження пароля</x-input-label>
            <x-text-input type="password" name="password_confirmation" required class="w-full p-2 mb-4"/>

            <x-blue-button>Скинути пароль</x-blue-button>
        </form>
    </div>
</x-app-layout>

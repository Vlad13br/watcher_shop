<h1>Підтвердіть свій email</h1>
<p>На вашу пошту надіслано лист. Перевірте та натисніть посилання.</p>
<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">Надіслати лист повторно</button>
</form>

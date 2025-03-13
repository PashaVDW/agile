<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" dir="ltr" lang="nl">
@include("auth.partials.head")

<body class="h-full flex items-center justify-center bg-[var(--input-background)] text-gray-900">

<div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg relative w-full">
    <div class="card relative">
        @include("auth.partials.back_button")

        <form action="{{ route('register') }}" class="card-body relative" id="sign_up_form" method="POST">
            @csrf

            <div class="text-center mb-4">
                <h3>Registreren</h3>
            </div>

            <div class="text-center mb-3">
                <span class="text-sm text-gray-600">Al een account?</span>
                <a class="text-sm link text-red-500 hover:text-pink-500 transition" href="{{ route('login') }}">Inloggen</a>
            </div>

            @include('auth.partials.input_field', ['label' => 'E-mail', 'name' => 'email', 'placeholder' => 'test@example.com', 'type' => 'email'])
            @include('auth.partials.password_field', ['label' => 'Wachtwoord', 'name' => 'password', 'placeholder' => 'Voer wachtwoord in'])
            @include('auth.partials.password_field', ['label' => 'Bevestig Wachtwoord', 'name' => 'password_confirmation', 'placeholder' => 'Herhaal wachtwoord'])

            @include('auth.partials.button', ['id' => 'register-btn', 'text' => 'Registreren'])
        </form>
    </div>
</div>

<script>
    function togglePassword(name) {
        let input = document.querySelector(`input[name="${name}"]`);
        input.type = input.type === "password" ? "text" : "password";
    }
</script>

</body>
</html>

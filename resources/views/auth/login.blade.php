<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" dir="ltr" lang="nl">
<head>
    @include("admin.partials.head")
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="antialiased flex h-full text-base bg-[#ECEBFF] text-gray-900">
@include("auth.partials.theme")

<div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg relative w-full">

    <div class="card max-w-[400px] w-full bg-white shadow-lg rounded-lg p-8 border border-gray-200 relative">

        <a href="{{ url('/') }}" class="absolute top-4 left-4 flex items-center text-gray-700 hover:text-black transition">
            <i class="ki-filled ki-arrow-left text-xl"></i>
        </a>

        <form action="{{ route('login') }}" class="card-body flex flex-col gap-5 mt-4" id="sign_in_form" method="POST">
            @csrf
            <div class="text-center mb-2.5">
                <h3 class="text-2xl font-bold text-black leading-none mb-2.5">Inloggen</h3>
                <div class="flex items-center justify-center">
                    <span class="text-sm text-gray-600 me-1.5">Nog geen account?</span>
                    <a class="text-sm link text-red-500 hover:text-pink-500 transition" href="{{ route('register') }}">Registreren</a>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <span class="border-t border-gray-300 w-full"></span>
                <span class="text-xs text-gray-600 uppercase">of</span>
                <span class="border-t border-gray-300 w-full"></span>
            </div>

            <div class="flex flex-col gap-1">
                <label class="form-label text-black">E-mail</label>
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <div class="input flex items-center justify-between px-3 @error('email') border-red-500 @enderror" style="min-height: 48px;">
                    <input name="email" class="w-full text-black" placeholder="test@example.com" type="text" required />
                    <span class="invisible w-10"></span>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="form-label text-black">Wachtwoord</label>
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <div class="input flex items-center justify-between px-3 @error('password') border-red-500 @enderror" data-toggle-password="true" style="min-height: 48px;">
                    <input name="password" class="w-full text-black" placeholder="Voer wachtwoord in" type="password" required />
                    <button class="btn btn-icon" data-toggle-password-trigger="true" type="button">
                        <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden"></i>
                        <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block"></i>
                    </button>
                </div>
            </div>

            <button class="btn btn-primary flex justify-center text-white font-bold text-lg" type="submit">
                Inloggen
            </button>
        </form>
    </div>
</div>

<script src="{{ asset('assets/js/core.bundle.js') }}"></script>
<script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>

</body>
</html>

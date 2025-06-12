@extends("layouts.default")

@section("title", "Forgot password")

@section('content')
    <div class="max-w-md mx-auto mt-10">
        <h2 class="text-xl font-semibold mb-4">Wachtwoord vergeten</h2>

        @if (session('status'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">E-mailadres</label>
                <input type="email" name="email" required class="w-full p-2 border rounded"
                       value="{{ old('email') }}">
                @error('email')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn w-full">Wachtwoord reset link versturen</button>
        </form>
    </div>
@endsection

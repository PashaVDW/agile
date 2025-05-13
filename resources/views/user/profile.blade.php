@extends("layouts.default")

@section("title", "Profiel")

@section("content")
    <div class="section">
        <div class="container">
            <div class="profile-wrapper">
                <div class="profile-information">
                    <h2>Gegevens</h2>
                    <form method="POST" action="{{ route('user.profile.update') }}">
                        @csrf
                        <x-forms.input-field type="text" name="name" label="Naam" :required="true" value="{{ old('name', $user->name ?? '')}}"/>
                        <x-forms.input-select name="major" :required="true" label="Major" :enum="$majors" value="{{ old('major', $user->major ?? '')}}"/>
                        <x-forms.input-field type="email" name="email" label="Email" :required="true" value="{{ old('email', $user->email ?? '')}}"/>
                        <x-forms.input-field type="phone" name="phone" label="Telefoonnummer" :required="true" value="{{ old('phone', $user->phone ?? '')}}"/>
                        <button class="item-button" type="submit" name="update_user">Update gegevens</button>
                    </form>
                </div>

                <div class="password-information">
                    <h2>Wachtwoord</h2>
                    <form method="POST" action="{{ route('user.password.update') }}">
                        @csrf
                        <x-forms.input-field type="password" name="current_password" label="Huidig wachtwoord" :required="true"/>
                        <x-forms.input-field type="password" name="password" label="Nieuw wachtwoord" :required="true"/>
                        <x-forms.input-field type="password" name="password_confirmation" label="Herhaal nieuw wachtwoord" :required="true"/>
                        <button class="item-button" type="submit" name="update_user_password">Update wachtwoord</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

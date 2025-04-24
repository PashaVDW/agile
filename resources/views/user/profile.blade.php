@extends("layouts.default")

@section("title", "Profiel")

@section("content")
    <div class="section">
        <div class="container">
            <div class="profile-wrapper">
                <form>
                    <x-forms.input-field type="text" name="name" label="Naam" :required="true" value="{{ old('name', $user->name ?? '')}}"/>
                    <x-forms.input-select name="major" :required="true" label="Major" :enum="$majors" value="{{ old('major', $user->major ?? '')}}"/>
                    <x-forms.input-field type="email" name="email" label="Email" :required="true" value="{{ old('email', $user->email ?? '')}}"/>
                    <x-forms.input-field type="phone" name="phone" label="Telefoonnummer" :required="true" value="{{ old('phone', $user->phone ?? '')}}"/>
                </form>
            </div>
        </div>
    </div>
@stop

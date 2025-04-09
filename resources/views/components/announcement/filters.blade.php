<form method="GET" action="{{ route(Route::currentRouteName()) }}">
    <label for="status" class="label">Status</label>
    <div class="select is-fullwidth">
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="">{{ __('Alle statussen') }}</option>
            @foreach(\App\Enums\ActiveTypeEnum::cases() as $option)
                <option value="{{ $option->value }}" @if(request('status') === $option->value) selected @endif>
                    {{ __($option->name) }}
                </option>
            @endforeach
        </select>
    </div>
</form>

@extends("layouts.default")

@section("title", "Assignments")

@section("content")
    <div class="section">
        <div class="container has-sidebar">
            <div class="items-wrapper">
                <div class="items">
                    @foreach($assignments as $assignment)
                        <x-item :item="$assignment" route="user.assignment.show"/>
                    @endforeach
                </div>
                <div class="pagination">
                    {{ $assignments->links() }}
                </div>
            </div>
            <div class="sidebar">
                <x-filters.dropdown :onchange="'this.form.submit()'" label="Status" default="All statuses" name="status" enum="{{\App\Enums\ActiveTypeEnum::class}}" value="{{ request('status') }}"/>
            </div>
        </div>
    </div>
@stop

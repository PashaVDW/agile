@extends("layouts.default")

@section("title", "Home")

@section("content")
    <div class="flex justify-center items-center h-screen">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn bg-[var(--red)] text-white font-bold p-3 rounded-lg shadow-md hover:bg-[var(--blue)] transition" type="submit">
                Logout
            </button>
        </form>
    </div>
@stop

<!DOCTYPE html>
<html>
  <head>
    <title>Sponsors</title>
  </head>
  <body>
    <h1>Sponsors</h1>
    <a href="{{ route("sponsors.create") }}">Add Sponsor</a>
    <ul>
      @foreach ($sponsors as $sponsor)
        <li>
          <img src="{{ $sponsor->logo }}" alt="Logo" width="50" />
          {{ $sponsor->name }} - {{ $sponsor->description }}
          [{{ $sponsor->active ? "Active" : "Inactive" }}]
          <br />
          <strong>Events:</strong>
          @foreach ($sponsor->events as $event)
            {{ $event->name }},
          @endforeach

          <br />
          <a href="{{ route("sponsors.edit", $sponsor) }}">Edit</a>
          |
          <form
            method="POST"
            action="{{ route("sponsors.destroy", $sponsor) }}"
            style="display: inline"
          >
            @csrf
            @method("DELETE")
            <button type="submit">Delete</button>
          </form>
        </li>
      @endforeach
    </ul>
  </body>
</html>

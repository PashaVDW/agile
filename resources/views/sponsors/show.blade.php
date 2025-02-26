<!DOCTYPE html>
<html>
  <head>
    <title>View Sponsor</title>
  </head>
  <body>
    <h1>View Sponsor</h1>
    <img src="{{ $sponsor->logo }}" alt="Logo" width="100" />
    <br />
    <strong>Name:</strong>
    {{ $sponsor->name }}
    <br />
    <strong>Description:</strong>
    {{ $sponsor->description }}
    <br />
    <strong>Active:</strong>
    {{ $sponsor->active ? "Yes" : "No" }}
    <br />
    <strong>Events:</strong>
    <ul>
      @foreach ($sponsor->events as $event)
        <li>{{ $event->name }}</li>
      @endforeach
    </ul>
    <a href="{{ route("sponsors.index") }}">Back to List</a>
  </body>
</html>

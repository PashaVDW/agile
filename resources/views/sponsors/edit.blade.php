<!DOCTYPE html>
<html>
  <head>
    <title>Edit Sponsor</title>
  </head>
  <body>
    <h1>Edit Sponsor</h1>
    <form method="POST" action="{{ route("sponsors.update", $sponsor) }}">
      @csrf
      @method("PUT")
      <label>
        Logo URL:
        <input type="text" name="logo" value="{{ $sponsor->logo }}" />
      </label>
      <br />
      <label>
        Name:
        <input type="text" name="name" value="{{ $sponsor->name }}" />
      </label>
      <br />
      <label>
        Description:
        <textarea name="description">{{ $sponsor->description }}</textarea>
      </label>
      <br />
      <label>
        Active:
        <input
          type="checkbox"
          name="active"
          value="1"
          {{ $sponsor->active ? "checked" : "" }}
        />
      </label>
      <br />
      <label>Events:</label>
      <br />
      @foreach ($events as $event)
        <label>
          <input
            type="checkbox"
            name="events[]"
            value="{{ $event->id }}"
            {{ $sponsor->events->contains($event->id) ? "checked" : "" }}
          />
          {{ $event->name }}
        </label>
        <br />
      @endforeach

      <button type="submit">Update</button>
    </form>
  </body>
</html>

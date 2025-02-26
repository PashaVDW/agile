<!DOCTYPE html>
<html>
  <head>
    <title>Add New Sponsor</title>
  </head>
  <body>
    <h1>Add New Sponsor</h1>
    <form method="POST" action="{{ route("sponsors.store") }}">
      @csrf
      <label>
        Logo URL:
        <input type="text" name="logo" />
      </label>
      <br />
      <label>
        Name:
        <input type="text" name="name" />
      </label>
      <br />
      <label>
        Description:
        <textarea name="description"></textarea>
      </label>
      <br />
      <label>
        Active:
        <input type="checkbox" name="active" value="1" checked />
      </label>
      <br />
      <label>Events:</label>
      <br />
      @foreach ($events as $event)
        <label>
          <input type="checkbox" name="events[]" value="{{ $event->id }}" />
          {{ $event->name }}
        </label>
        <br />
      @endforeach

      <button type="submit">Save</button>
    </form>
  </body>
</html>

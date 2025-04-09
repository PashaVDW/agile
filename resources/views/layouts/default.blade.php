<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>{{ config("app.name") }} | @yield("title")</title>
    @vite(['resources/assets/js/app.js'])
  </head>
  @php
      if (strpos(Route::current()->getName(), '.') !== false) {
          $parts = explode('.', Route::current()->getName());
          $className = $parts[1]; // user.events.index -> events
      }
      else {
          $className = Route::current()->getName();
      }
  @endphp
  <body class="{{$className}}">
    <x-navbar />
    <main>
      @yield("content")
    </main>

    <x-footer />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>

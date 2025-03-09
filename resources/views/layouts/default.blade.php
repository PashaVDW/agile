<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
    <main>
      @yield("content")
    </main>
  </body>
</html>

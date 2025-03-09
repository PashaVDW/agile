<!DOCTYPE html>
<html>
  <head>
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

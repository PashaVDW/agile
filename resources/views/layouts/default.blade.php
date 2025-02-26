<!DOCTYPE html>
<html>
  <head>
    <title>{{ config("app.name") }} | @yield("title")</title>
      @vite(['resources/assets/js/app.js'])
  </head>

  <body>
    <main>
      @yield("content")
    </main>
  </body>
</html>

<!DOCTYPE html>
<html>
  <head>
    <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
    <title>{{ config("app.name") }} | @yield("title")</title>
    @vite(["resources/assets/js/app.js"])
  </head>

  <body>
    <main>
      @yield("content")
    </main>
  </body>
</html>

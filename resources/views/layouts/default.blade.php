<!DOCTYPE html>
<html>
  <head>
    <title>{{ config("app.name") }} | @yield("title")</title>
  </head>

  <body>
    <main>
      @yield("content")
    </main>
  </body>
</html>

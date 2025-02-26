<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <title>{{ config("app.name") }} | @yield("title")</title>
  </head>

  <x-navbar />
  
  <body>
    <main>
      @yield("content")
    </main>
  </body>
</html>

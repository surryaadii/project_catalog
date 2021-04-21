<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('assets/frontend/images/logo.svg')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{!! config('app.name') !!}</title>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/app.css') }}">
  </head>
  <body>
    <noscript>Sorry, your browser does not support JavaScript!</noscript>
    <div id="app">
        <app />
    </div>
    <script src="{{ asset('assets/frontend/js/app.js') }}"></script>
  </body>
</html>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!--<title>{{ config('app.name') }}</title>-->
  <title>メカトロ同好会エルチカ</title>

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}" defer></script>

  <!-- Fonts -->

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

</head>
<body>
  <div id="app"></div>
</body>
</html>
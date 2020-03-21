<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <link rel="shortcut icon" href="/favicon.ico"/>
  <title>{{$title}}</title>
  <meta property="og:title" content="{{$title}}">
  <meta property="og:image" content="{{$image_url}}">
  <meta property="og:description" content="{{$description}}">
  <meta property="og:url" content="{{$url}}">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="メカトロ同好会エルチカ">
  <meta name="twitter:site" content="{{$url}}">
  <meta name="twitter:card" content="summary">
  <meta name="twitter:title" content="{{$title}}">
  <meta name="twitter:image" content="{{$image_url}}">
  <meta name="twitter:description" content="{{$description}}">
</head>
  <body>
  </body>
</html>
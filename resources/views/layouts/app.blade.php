<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('image/brand_logo.png') }}">

  <link href="{{ asset('assets/css/output.css') }}" rel="stylesheet">

  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>

<body>
  <div class="w-full">
      @include('includes.navbar')
      @yield('content')
  </div>

    <script src="{{ asset('assets/js/appMain.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/swiper.js') }}"></script>
</body>

</html>
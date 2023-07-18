<html>
<head>
  <meta charset="UTF-8">
  <title>@section('tittle')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script  src="{{asset('navbar.js')}}"></script>
</head>
<body>
  
  @include("Exchange::layouts.elements.navbar")
  @yield('content')

  @yield('scripts')

  
</body>

</html>
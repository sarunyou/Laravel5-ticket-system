<html>

<head>
  <title> @yield('title') </title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Include roboto.css to use the Roboto web font, material.css to include the theme and ripples.css to style the ripple effect -->
  <link href="{!! asset('css/bootstrap-material-design.min.css') !!}" rel="stylesheet">
  <link href="{!! asset('css/ripples.min.css') !!}" rel="stylesheet">
</head>

<body>

  @include('shared.navbar') @yield('content')

</body>

</html>

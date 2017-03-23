<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | Result</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/schoolite.css') }}" rel="stylesheet">


</head>

<body class="white-bg result-page">
      <div class="wrapper wrapper-content">

           @yield('result-heading')

           @yield('result-body')

           @yield('result-footer')
      </div>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>

<!DOCTYPE html>
<html lang="pt-br">

<head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @yield('title')

        @yield('css')
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap-4.6.2/dist/css/bootstrap.min.css') }}">

</head>    

<body>
    @yield('content')


    <script src="{{ asset('vendor/jquery/jquery-3.6.3.min.js') }}"></script>
    @yield('js')

</body>

</html>

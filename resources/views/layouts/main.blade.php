<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
@include('components.menu')

@include('components.alerts')

@yield('content')

</body>
</html>

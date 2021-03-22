<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
@include('components.header')
<div class="content">
    @yield('content')
</div>
</body>
</html>

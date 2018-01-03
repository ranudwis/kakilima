<html>
<head>
    <title>Kaki Lima</title>
    <link rel="stylesheet" href="{{ url('/css/style.css') }}">
    <link rel="shortcut icon" href="{{ url('/images/logoSmall.png') }}">
</head>
<body>
    @include('layouts.navbar')
    <div id="content">
        @yield('content')
    </div>
    @include('layouts.footer')
</body>
</htmL>

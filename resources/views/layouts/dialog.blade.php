<html>
<head>
    <title>Kaki Lima</title>
    <link rel="stylesheet" href="{{ url('/css/style.css') }}">
    <link rel="shortcut icon" href="{{ url('/images/logoSmall.png') }}">
</head>
<body>
    <div id="singleLogo">
        <a href="{{ route('home') }}">
            <img src="{{ url('images/logo.png') }}">
        </a>
    </div>
    <div id="content">
        @yield('content')
    </div>
    @include('layouts.notification')
    @include('layouts.footer')
</body>
</html>
@if(Auth::check() && Auth::user()->isAdmin()) @php $admin = true @endphp
@else @php $admin = false @endphp
@endif
@php
    if(Auth::check() && Auth::user()->isAdmin()){
        $admin = true;
    }else{
        $admin = false;
    }
    if(request()->is('dashboard/*') || request()->is('dashboard')){
        $white = 'White';
    }else{
        $white = '';
    }
@endphp
<html>
<head>
    <title>Kaki Lima</title>
    <link rel="stylesheet" href="{{ url('/css/style.css') }}">
    <link rel="shortcut icon" href="{{ url('/images/logoSmall.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ url('/js/jquery-3.2.1.min.js') }}"></script>
</head>
<body>
    @unless(isset($dialog))
        @include('layouts.navbar')
    @endunless
    <div id="content" @isset($dashboard) class="nopadding" @endisset>
        @yield('content')
    </div>
    @include('layouts.notification')
    @yield('footer')
    @include('layouts.footer')
</body>
</html>
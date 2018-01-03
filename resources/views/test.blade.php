<html>
<head>
    <style>
    div{
        height: 50px;
        display: flex;
    }
    img{
        height: 100%;
    }
    a{
        flex: 0 0 auto;
    }
    </style>
</head>
<body>
    <div>
        <a href="{{ route('home') }}">
            <img src="{{ url('/images/logo.png') }}">
        </a>
        <a href="{{ route('home') }}">
            <img src="{{ url('/images/logo.png') }}">
        </a>
    </div>
</body>
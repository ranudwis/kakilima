<html>
<head>
    <title>Test</title>
    <script src="{{ url('/js/jquery-3.2.1.min.js') }}"></script>
    <meta name="csrf-token" value="{{ csrf_token() }}">
</head>
<body>
    @yield('content')
    <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"').attr('content')
        }
    })
    $(document).ajaxError(function(a,b,c,d){
        // console.log(b.responseText);
        console.log(c);
        console.log("ajax error" + d);
    })
    $("#addImage").click(function(){
        $(this).next().clone().val("").appendTo($(this).parent());
    })
    $('.addToCart').click(function(event){
        event.preventDefault();
        window.location = $(this).attr("href") + "&quantity=" + $(this).prev().val();
        // $.post("{{ route('addcart') }}",{
        //     item: $(this).attr("href").substr(15),
        //     quantity: $(this).prev().val()
        // },function(data){
        //     console.log(data);
        //     alert("sukses");
        // })
    })
    // #(".addToCart").click(function(event){
    //     event.preventDefault();
    //     console.log($(this).attr("href"));
        // $.post({{ route('addcart') }},{
        //     item: $(this).attr("href")
        // })
    // })
    </script>
    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
</body>
</html>
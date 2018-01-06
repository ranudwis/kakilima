<script>
    var basepath = "{{ url('/') }}";
</script>
@if($errors->has('cm'))
    <div id="notification" class="error hide">
        <i class="fa fa-warning fa-fw"></i>{{ $errors->first('cm') }}
    </div>
@elseif($errors->any())
    <script>
        var errors = {
        @foreach($errors->toArray() as $name => $error)
            {{$name}}:"{{$error[0]}}",
        @endforeach
        }
    </script>
    <div id="notification" class="hide">
    </div>
@elseif(Session::has('cm'))
    <div id="notification" class="notify hide">
        <i class="fa fa-info-circle fa-fw"></i>{{ Session::get('cm') }}
    </div>
@else
    <div id="notification" class="hide">
    </div>
@endif

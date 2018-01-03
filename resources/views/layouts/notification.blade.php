<script>
    var basepath = "{{ url('/') }}";
</script>
@if($errors->has('cm'))
    <div id="notification" class="error hide">
        {{ $errors->first('cm') }}
    </div>
@elseif($errors->any())
    <script>
        var errors = {
        @foreach($errors->toArray() as $name => $error)
            {{$name}}:"{{$error[0]}}",
        @endforeach
        }
    </script>
@elseif(Session::has('cm'))
    <div id="notification" class="notify hide">
        {{ Session::get('cm') }}
    </div>
@else
    <div id="notification" class="hide">
    </div>
@endif

@if($errors->any())
<div id="notification" class="hide error">
    Terjadi kesalahan:
    <ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@elseif(Session::has('cm'))
<div id="notification" class="hide notify">
    {{ session('cm') }}
</div>
@endif
<script src="{{ url('/js/script.js') }}"></script>
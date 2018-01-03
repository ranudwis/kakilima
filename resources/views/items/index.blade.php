@foreach($items as $item)
    <a href="{{ route('showitem',['item' => $item->slug]) }}">{{ $item->name }}</a>
@endforeach
@foreach($items as $item)
    <a href="{{ route('item.show',['item' => $item->slug]) }}">{{ $item->name }}</a>
@endforeach

@extends('layouts.master',['dashboard' => true])

@section('content')
    <?php
        $link = false;
        $dashboardLink = [
            "" => "Ikhtisar",
            "kategori" => [
                "tambah" => "Tambah kategori",
                "statistik" => "Statistik kategori",
            ],
            "kupon" => [
                "tambah" => "Tambah kupon",
                "tampil" => "Tampil kupon"
            ],
            "transaksi" => "Transaksi"
        ]
    ?>
    <div id="dashboardNavigator">
        <ul>
            @foreach($dashboardLink as $name => $dash)
                @if(is_array($dash))
                    <li><span @if($linkName === $name) class="active" @endif>{{ $name }}</span>
                        <ul @if($linkName === $name) style="display:block" @endif>
                            @foreach($dash as $nam => $das)
                                <li><a @if(!$link && $linkName == $name && $subLink == $nam) class="active" @php $link = true @endphp @endif href="{{ route('board',['board'=>$name,'subboard'=>$nam]) }}">{{ $das }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li><a @if(!$link && $linkName === $name || ($loop->first && $linkName == "")) class="active" @php $link = true @endphp @endif href="@if($loop->first) {{ route('dashboard') }} @else {{ route('board',['board'=>$name]) }} @endif">{{ $dash }}</a></li>
                @endif
            @endforeach
        </uL>
    </div>
    <div id="dashboardContent">
        @if($linkName == "")
            @include('dashboard.overview')
        @else
            @php
                $link = $subLink == "" ? $linkName : $linkName.'.'.$subLink;
            @endphp
            @if(View::exists('dashboard.'.$link))
                @include('dashboard.'.$link)
            @else
                not found
            @endif
        @endif
    </div>
@endsection
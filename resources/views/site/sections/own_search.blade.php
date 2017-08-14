@extends('site.master')
@section('title')Photography inspiration by color@stop
@section('description')Photography inspiration by color@stop
@section('keywords')photography,inspiration,photo,color@stop
@section('content')

    <div class="categories">
        <div class="container">
            <?php
                $rgb = explode("-", $color);
            ?>
            <h3>Results for color search: <strong>Red {{ $rgb[0] }}, Green {{ $rgb[1] }}, Blue {{ $rgb[2] }}</strong></h3>
        </div>
    </div>


    <div class="color_photo_grid">
        {{--{{ dd($photos) }}--}}
        @foreach($photos as $photo)
            <div class="single wrapper" data-repeat="{{ $photo->uid }}">
                <div class="vote">
                    <span>{{ $photo->votes }}</span><div class="vote-icon normal"></div>
                </div>
                <a class="photo" data-id="{{ $photo->uid }}" href="{{ $photo->user_profile }}" target="_blank" style="background-image: url('{{ $photo->photo }}')">
                    <p> {{ $photo->title }} </p>
                </a>
                <a href="{{ $photo->user_profile }}" class="author" target="_blank">
                    <p>@if($photo->user_name) {{$photo->user_name}} @else {{$photo->user_nickname}} @endif</p>
                </a>
                <div class="color_block color_top">
                    @foreach(json_decode($photo->palette_color) as $color)
                        <span class="searchByColor" data-color="{{$color->red}}-{{$color->green}}-{{$color->blue}}" style="background: rgb( {{$color->red}},{{$color->green}},{{$color->blue}} )"></span>
                    @endforeach
                </div>
                <?php
                $average = json_decode($photo->average_color)[0];
                $averageData = $average->red.'-'.$average->green.'-'.$average->blue;
                $averageRGB = 'rgb('.$average->red.', '.$average->green.', '.$average->blue.')';
                ?>
                <div class="color_block color_bottom searchByColor" data-color="{{ $averageData }}" style="background: {{ $averageRGB }}"><span>Average color: {{ $averageRGB }}</span></div>
            </div>
        @endforeach
    </div>
@endsection
@section('scripts')
    <script>
        var PhotosById = [];
        $.each( $('.single.wrapper'), function () {
            var ID = $(this).data('repeat');
            if($.inArray(ID, PhotosById)) {
                PhotosById.push(ID);
            }
        });

        $.each( PhotosById, function (index, value) {
            var $div = $('.single[data-repeat='+value+']');
            console.log($div);
            if ($div.length > 1) {
                $div.not(':last').remove()
            }
        });

        console.log(PhotosById);
    </script>
@endsection
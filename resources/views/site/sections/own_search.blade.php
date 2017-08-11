@extends('site.master')
@section('title')Photography inspiration for {{ $keyword }}@stop
@section('description')Photography inspiration for {{ $keyword }}@stop
@section('keywords')photography,inspiration,photo,{{ $keyword }}@stop


@section('content')


    {{--<div class="color_photo_grid">--}}
        {{--@foreach($photos as $photo)--}}
            {{--<div class="single wrapper">--}}
                {{--<div class="vote">--}}
                    {{--<span>{{ $photo->votes }}</span><div class="vote-icon normal"></div>--}}
                {{--</div>--}}
                {{--<a class="photo" data-id="{{ $photo->uid }}" href="{{ $photo->user_profile }}" target="_blank" style="background-image: url('{{ $photo->photo }}')">--}}
                    {{--<p> {{ $photo->title }} </p>--}}
                {{--</a>--}}
                {{--<a href="{{ $photo->user_profile }}" class="author" target="_blank">--}}
                    {{--<p>@if($photo->user_name) {{$photo->user_name}} @else {{$photo->user_nickname}} @endif</p>--}}
                {{--</a>--}}
                {{--<div class="color_block color_top">--}}
                    {{--@foreach(json_decode($photo->palette_color) as $color)--}}
                        {{--<span class="searchByColor" data-color="{{$color->red}},{{$color->green}},{{$color->blue}}" style="background: rgb( {{$color->red}},{{$color->green}},{{$color->blue}} )"></span>--}}
                    {{--@endforeach--}}
                {{--</div>--}}
                {{--<?php--}}
                {{--$average = json_decode($photo->average_color)[0];--}}
                {{--$averageData = $average->red.','.$average->green.','.$average->blue;--}}
                {{--$averageRGB = 'rgb('.$average->red.', '.$average->green.', '.$average->blue.')';--}}
                {{--?>--}}
                {{--{{ dd( $average) }}--}}
                {{--<div class="color_block color_bottom searchByColor" data-color="{{ $averageData }}" style="background: {{ $averageRGB }}"><span>Average color: {{ $averageRGB }}</span></div>--}}
            {{--</div>--}}
        {{--@endforeach--}}
    {{--</div>--}}
@endsection


@section('scripts')
@endsection
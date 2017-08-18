@extends('site.master')
@section('title')Photography Inspiration | photography is art @stop
@section('description')Best website for photography inspiration, photography is art, photography is all @stop
@section('keywords')photography,inspiration,photo @stop

@section('content')

    <div class="container">
        <div class="color_photo_grid single-grid">
            <div class="single wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <div class="relative photo-wrapper">
                            <div class="vote">
                                <span>{{ $photo->votes }}</span><div class="vote-icon normal"></div>
                                <div class="loading">
                                    <div class="bubble-1"></div>
                                    <div class="bubble-2"></div>
                                </div>
                            </div>
                            <div class="photo" data-id="{{ $photo->uid }}" style="background-image: url('{{ $photo->photo }}')">
                                <p> {{ $photo->title }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info">
                            <div class="title"><h2>{{ $photo->title }}</h2></div>
                            <div class="description">
                                {!! $photo->description !!}
                            </div>
                            <div class="colors">
                                <?php
                                $average = json_decode($photo->average_color)[0];
                                $averageData = $average->red.'-'.$average->green.'-'.$average->blue;
                                $averageRGB = 'rgb('.$average->red.', '.$average->green.', '.$average->blue.')';
                                ?>
                                <div class="average">
                                    <p>
                                        Average color: <strong>{{ $averageRGB }}</strong>
                                    </p>
                                    <p>
                                        <span class="color_block searchByColor" data-color="{{ $averageData }}" style="background: {{ $averageRGB }}"></span>
                                    </p>
                                </div>
                                <div class="palette">
                                    <p>
                                        Palette color:
                                    </p>
                                    <p>
                                    @foreach(json_decode($photo->palette_color) as $color)
                                        <span class="color_block searchByColor" data-color="{{$color->red}}-{{$color->green}}-{{$color->blue}}" style="background: rgb( {{$color->red}},{{$color->green}},{{$color->blue}} )"></span>
                                    @endforeach
                                    </p>
                                </div>
                                @if($photo->views>0)
                                    <div class="views">
                                        <p>Views: {{ $photo->views }}</p>
                                    </div>
                                @endif
                                <div class="cta">
                                    <a class="btn" href="{{ $photo->user_profile }}">Check on Flickr</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="categories">
        <div class="container">
            <h3>Check this out</h3>
        </div>
    </div>

    <div class="color_photo_grid">
        @foreach($photos as $photo)
            <div class="single wrapper">
                <div class="vote">
                    <span>{{ $photo->votes }}</span><div class="vote-icon normal"></div>
                    <div class="loading">
                        <div class="bubble-1"></div>
                        <div class="bubble-2"></div>
                    </div>
                </div>
                {{--{{ $photo->user_profile }}--}}
                <a class="photo" data-id="{{ $photo->uid }}" href="/photo/{{ $photo->id }}" target="_blank" style="background-image: url('{{ $photo->photo }}')">
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
                {{--{{ dd( $average) }}--}}
                <div class="color_block color_bottom searchByColor" data-color="{{ $averageData }}" style="background: {{ $averageRGB }}"><span>Average color: {{ $averageRGB }}</span></div>
            </div>
        @endforeach
    </div>



<div class="add">
    <div class="center" id="home-add">
        <div class="leaderboard"></div>
    </div>
</div>

<div id="searchResult"></div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var limit_add = 3,
            actual_add_position = 0;

        var homeArguments = ['outside', 'people', 'macro', 'landscape', 'street', 'city', 'new'];
        var argument = homeArguments[Math.floor(Math.random() * homeArguments.length)];

        $(document).ready(function () {
            _generateResurlts(argument  , 7);
            $("#home-add").html(GlobalAdd);
            (adsbygoogle = window.adsbygoogle || []).push({});
        });
    </script>
@endsection
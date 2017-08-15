@extends('site.master')
@section('title')Photo inspiration | photography is art @stop
@section('description')Best website for photography inspiration, photography is art, photography is all @stop
@section('keywords')photography,inspiration,photo @stop

@section('content')
<div class="welcome">
    <div class="vertical-align">
        <div class="container">
            <h2>Get inspired by Text search or color</h2>
            {{--<p>Yep, we just start</p>--}}
            <br><br><br>
            <div class="row home-tuto">
                <div class="col-md-6">
                    <p class="small">Search for something interesting and help us to get better by doing "Love" on result's photos.</p>
                    <form  action="/search" method="get" class="GA_HOME_SEARCH_EVENT">
                        <input type="text"id="homeInputSearch" name="q" placeholder="Concert..."/>
                        <button type="submit">Search</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <p class="small">¿Love colors?, the pick four favorite one and see the magic.</p>
                    @include('site.partials._color_picker')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="how-it-works">
    <div class="square">
        <p class="title">HOW DOES IT WORK?</p>
        <div class="description">
            <p>By clicking "Love" on the photos that you think are great, you are helping us organize these really cool photos by color so you can search them by category or color. Isn't that great?</p>
            <p>There are many photos out there, but you can inspire yourself and others with your help.</p>
        </div>
    </div>
    {{--<p class="description"><strong>{{ env('APP_FULLNAME') }}</strong> use Flickr API <em>(we are working on Instagram right now)</em> to get photos and organized by color, we are just started to get the average color of each photo you like, <strong>more you like more that you help us to get.</strong></p>--}}
</div>

<div class="categories">
    <div class="container">
        <h3>Popular on {{ env('APP_FULLNAME') }}</h3>
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
            {{--{{ dd( $average) }}--}}
            <div class="color_block color_bottom searchByColor" data-color="{{ $averageData }}" style="background: {{ $averageRGB }}"><span>Average color: {{ $averageRGB }}</span></div>
        </div>
    @endforeach
</div>

<div class="categories">
    <div class="container">
        <h3>Popular categories {{ env('APP_FULLNAME') }}</h3>
        <?php
        $popular = ['animals', 'beach', 'flower', 'nyc', 'berlin', 'sunrise', 'bay', 'sky', 'sunset', 'people', 'lake', 'pink'];
        $random = shuffle_assoc($popular);
        $result = array_slice($random, 0, 6);

        function shuffle_assoc($list) {
            if (!is_array($list)) return $list;
            $keys = array_keys($list);
            shuffle($keys);
            $random = array();
            foreach ($keys as $key) {
                $random[$key] = $list[$key];
            }
            return $random;
        }
        ?>
        <ul>
            @foreach($result as $item)
                <li>
                    <span data-search="{{ $item }}">{{ $item }}</span>
                </li>
            @endforeach
        </ul>
    </div>
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
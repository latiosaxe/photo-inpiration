@extends('site.master')
@section('title')Photo inspiration | photography is art @stop
@section('description')Best website for photography inspiration, photography is art, photography is all @stop
@section('keywords')photography,inspiration,photo @stop

@section('content')
<div class="welcome">
    <div class="vertical-align">
        <div class="container">
            <h2>Inspiring Photos Since 2017</h2>
            <p>Yep, we just start</p>
            <br><br><br>
            <p class="small">Search for something interesting</p>
            <form  action="/search" method="get" class="GA_HOME_SEARCH_EVENT">
                <input type="text"id="homeInputSearch" name="q" placeholder="Concert..."/>
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
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
            </div>
            <a class="photo" data-id="{{ $photo->uid }}" href="{{ $photo->user_profile }}" target="_blank" style="background-image: url('{{ $photo->photo }}')">
                <p> {{ $photo->title }} </p>
            </a>
            <a href="{{ $photo->user_profile }}" class="author" target="_blank">
                <p>@if($photo->user_name) {{$photo->user_name}} @else {{$photo->user_nickname}} @endif</p>
            </a>
            <?php
                $colorsSplit = explode("|", $photo->palette_color);
            ?>
            <div class="color_block color_top">
                @foreach($colorsSplit as $single)
                    @if($single)
                        <span style="background: {{ $single }}"></span>
                    @endif
                @endforeach
            </div>
            <div class="color_block color_bottom" style="background: {{ $photo->average_color }}"><span>Average color: {{ $photo->average_color }}</span></div>
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




{{--<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">--}}
    {{--<img itemprop="image" class="post_preview" alt="Article title" class="hide-for-small" src="http://example.co.uk/wp-content/uploads/2016/02/example-image.jpg" />--}}
    {{--<meta itemprop="url" content="http://example.co.uk/wp-content/uploads/2016/02/example-image.jpg">--}}
    {{--<meta itemprop="width" content="800">--}}
    {{--<meta itemprop="height" content="800">--}}
{{--</div>--}}
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
            <form  action="/search" method="get">
                <input type="text"  name="q" placeholder="Concert..."/>
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</div>
<div class="categories">
    <div class="container">
        <h3>Popular on {{ env('APP_NAME') }}</h3>
        <?php
        $popular = ['animals', 'beach', 'flower', 'nyc', 'berlin', 'sunrise'];
        ?>
        <ul>
            @foreach($popular as $item)
                <li>
                    <span data-search="{{ $item }}">{{ $item }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="add" id="home-add">
    <div class="center">
        <div class="leaderboard"></div>
    </div>
</div>

<div id="searchResult"></div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var limit_add = 6,
                actual_add_position = 0;

        var homeArguments = ['outside', 'portrait', 'macro', 'landscape', 'street', 'city', 'new'];
        var argument = homeArguments[Math.floor(Math.random() * homeArguments.length)];

        $(document).ready(function () {
            _generateResurlts(argument  , 6);
            $("#home-add").html(GlobalAdd);
        });
    </script>
@endsection
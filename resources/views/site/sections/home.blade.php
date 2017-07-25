@extends('site.master')
@section('title')Photo inspiration | photography is art @stop
@section('description')Best website for photography inspiration, photography is art, photography is all @stop

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

<div id="searchResult"></div>
@endsection

@section('scripts')
    <script type="text/javascript">

        var limit_add = 6,
            actual_add_position = 0;

        $(document).ready(function () {
            var API_FLICKR_KEY = '0c72858bd7b4baffff57ab50e7a2f349';
            $.ajax({
                method: 'GET',
                url: 'https://www.flickr.com/services/rest',
                data: {
                    method: 'flickr.photos.search',
                    api_key: API_FLICKR_KEY,
                    tags: 'outside',
                    sort: 'relevance',
                    searchResult_type: 1,  //Only photos
                    format: 'json',
                    nojsoncallback: 1,
                    per_page: 6
                }
            }).done(function(data) {
                $("#searchResult").html('<ul class="result-list"></ul>');
                $.each(data.photos.photo, function (index, value) {
                    if(actual_add_position == (limit_add)){
                        $("#searchResult .result-list").append('<li class="add leaderboard"><span></span></li>');
                        actual_add_position = -1;
                    }else{
                        $("#searchResult .result-list").append('' +
                            '<li>' +
                                '<a href="https://www.flickr.com/photos/'+value.owner+'" target="_blank" style="background-image: url(https://farm'+value.farm+'.staticflickr.com/'+value.server+'/'+value.id+'_'+value.secret+'_b.jpg+)">' +
                                    '<p>' +
                                    ''+value.title+'' +
        //                                    '<img src="https://s.yimg.com/pw/images/buddyicon09.png#'+value.owner+'" alt="" class="avatar">'+
                                    '</p>' +
                                '</a>' +
                            '</li>' +
                        '');
                    }
                    actual_add_position ++;
                })
            });
        });
    </script>
@endsection
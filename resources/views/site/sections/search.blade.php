@extends('site.master')
@section('title')Photography inspiration for {{ $keyword }}@stop
@section('description')Photography inspiration for {{ $keyword }}@stop


@section('content')
    <div id="searchResult">
        <div class="boxLoading">
            <p class="textLoading">We are working on your search</p>
            <div class="block"></div>
        </div>
    </div>

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
//                text: 'surf',
                    text: '{{ $keyword }}',
                    sort: 'relevance',
                    searchResult_type: 1,  //Only photos
                    format: 'json',
                    nojsoncallback: 1,
                    per_page: 27
                }
            }).done(function(data) {
                $("#searchResult").html('<div class="resume-search"><div class="container"><p>Results to the search: <strong>{{ $keyword }}</strong></p></div></div>');
                $("#searchResult").append('<ul class="result-list"></ul>');
                $.each(data.photos.photo, function (index, value) {

                    console.log(value);

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
@extends('site.master')
@section('title')Photography inspiration for {{ $keyword }}@stop
@section('description')Photography inspiration for {{ $keyword }}@stop
@section('keywords')photography,inspiration,photo,{{ $keyword }}@stop


@section('content')

    <div id="searchResult">
        <div class="boxLoading">
            <p class="textLoading">We are working on your search</p>
            <div class="block"></div>
        </div>
    </div>

    <span id="argument" data-search="{{ $keyword }}"></span>
@endsection


@section('scripts')
    <script type="text/javascript">

        var limit_add = 3,
            actual_add_position = 0;


        var argument = $("#argument").data('search');
        $(document).ready(function () {
            _generateResurlts(argument  , 42);
        });
    </script>
@endsection
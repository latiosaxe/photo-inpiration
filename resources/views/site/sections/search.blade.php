@extends('site.master')
@section('title')Photography inspiration for {{ $keyword }}@stop
@section('description')Photography inspiration for {{ $keyword }}@stop
@section('keywords')photography,inspiration,photo,{{ $keyword }}@stop


@section('content')

    <div id="searchResult" style="min-height: 100vh;">
        <div class="boxLoading">
            <p class="textLoading">We are working on your search</p>
            <div class="block"></div>
        </div>
    </div>

    <span id="argument" data-search="{{ $keyword }}"></span>

    <div class="moreSearch hidden">
        <p class="text-center">
            <button class="btn moreSearch">Search more about this</button>
        </p>
    </div>

    <div class="error-search hidden">
        <p>Ups!, its seem that no one knows about it, try with another argument please.</p>
    </div>

    <div class="color-section">
        <p class="title">Make another search, try with a color</p>
        <p>Dont forget to like photos!</p>
        @include('site.partials._color_picker')
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        var limit_add = 3,
            actual_add_position = 0,
            init = 1;

        var argument = $("#argument").data('search');
        $(document).ready(function () {
            _generateResurlts(argument, 42, init);
        });


        $(".moreSearch").on('click', function () {
            init = init + 1;
            _generateResurlts(argument, 42, init);
        });
    </script>
@endsection
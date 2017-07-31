@extends('site.master')
@section('title')Photography inspiration for {{ $keyword }}@stop
@section('description')Photography inspiration for {{ $keyword }}@stop
@section('keywords')photography,inspiration,photo,{{ $keyword }}@stop


@section('content')

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Leaderborad Desktop -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:728px;height:90px"
         data-ad-client="ca-pub-4124457392679487"
         data-ad-slot="6016058684"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

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

        var limit_add = 6,
            actual_add_position = 0;


        var argument = $("#argument").data('search');
        $(document).ready(function () {
            _generateResurlts(argument  , 27);
        });
    </script>
@endsection
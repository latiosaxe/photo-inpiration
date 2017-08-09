@extends('site.master')
@section('title')Photo inspiration | photography is art @stop
@section('description')Best website for photography inspiration, photography is art, photography is all @stop
@section('keywords')photography,inspiration,photo @stop

@section('content')

    <div class="editorial">
        <div class="head">
            <div class="container">
                <h2>¿How it works?</h2>
            </div>
        </div>
        <div class="container">
            <div class="body">
                <p class="title">{{ env('APP_FULLNAME') }}</p>
                <p>{{ env('APP_FULLNAME') }} use Flickr API (we are working on Instagram right now) to get photos and organized by color, we are just started to get the average color of each photo you like, <strong>more you like more that you help us to get.</strong></p>

                <br><br>
                <p class="title">What's next?</p>
                <p>- Search by Color</p>
                <p>- Introduce Instagram API to each search to get better results</p>
                <p>- Better UX/UI</p>
                <p>- A better Logo ;)</p>
                <p>Wanna help?, please <a href="mailto:latiosaxe@gmail.com">send me a email</a> or <a href="https://twitter.com/latiosaxe" target="_blank">tweet</a></p>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
@endsection
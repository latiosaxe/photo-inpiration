@extends('site.master')
@section('content')

    <div class="editorial">
        <div class="head">
            <div class="container">
                <h2>How does it work?</h2>
            </div>
        </div>
        <div class="container">
            <div class="body">
                <p class="title">{{ env('APP_FULLNAME') }}</p>
                <p>{{ env('APP_FULLNAME') }} uses Flickr API (we are working on Instagram right now) to get photos and organized by color, we are just starting by using the average color of each photo you like. <strong>The more you like these photos, the more that you help us organize them.</strong></p>

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

    <script>

        var client_ID = 'da30bf69ad4b4bd8b57255f84ebb0a8c';

        var feed = new Instafeed({
            get: 'user',
            userId: 'USER_ID',
            accessToken: 'YOUR_ACCESS_TOKEN',
            filter: function(image) {
                return image.tags.indexOf('TAG_NAME') >= 0;
            }
        });
        feed.run();
    </script>
@endsection
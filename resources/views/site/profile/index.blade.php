@extends('site.master')
@section('content')

    <div class="user">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4>Hello {{ $username }}</h4>
                </div>
                <div class="col-md-6"></div>
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
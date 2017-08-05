<?php
$_seo = [
    'title'         => 'Photo inspiration | photography is art',
    'description'   => 'Best website for photography inspiration, photography is art, photography is all',
    'image'         => '/assets/images/social-share.jpg',
    'domain'        => env('APP_URL'),
    'canonical'     => URL()->current(),
];
if (isset($seo)){
    $seo = (object)array_merge( $_seo, (array)$seo);
}else{
    $seo = (object)$_seo;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <link rel="stylesheet" href="/assets/css/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Axel Gonzalez">

    <meta property="fb:app_id" content="{{env('FB_APP_ID')}}">
    <meta property="og:url" content="{{$seo->canonical}}">
    <meta property="og:site_name" content="Photography Inspiration">
    <meta property="og:title" content="{{$seo->title}}">
    <meta property="og:description" content="{{$seo->description}}">
    <meta property="og:image" content="{{$seo->domain}}{{$seo->image}}">
    <meta property="og:type"   content="website" />

    <meta name="twitter:account_id" content="" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{$seo->title}}">
    <meta name="twitter:creator" content="">
    <meta name="twitter:site" content="{{$seo->canonical}}">
    <meta name="twitter:description" content="{{$seo->description}}">
    <meta name="twitter:domain" content="{{$seo->domain}}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-103220384-1', 'auto');
        ga('send', 'pageview');

    </script>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-4124457392679487",
            enable_page_level_ads: true
        });
    </script>
</head>
<body>
<div class="site">
    <header>
        <div class="relative">
            <div class="logo">
                <a href="/">
                    <img src="/assets/images/photo_inspiration_logo_white.png" alt="Photo Inspiration">
                    <h1>{{ env('APP_FULLNAME') }}</h1>
                </a>
            </div>
            <div class="popular">
                <span>Popular <small>▼</small></span>
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
            <div class="search">
                <form  action="/search" method="get" class="GA_SEARCH_EVENT">
                    <input type="text" id="globalInputSearch" name="q" placeholder="Concert..." required="required"/>
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>
    </header>
    <div class="fake-header"></div>

    <div class="latiosaxe" id="latiosaxe">
        @yield('content')
    </div>

    <footer>
        <div class="container">
            <div class="half">
                <p>All rights reserved</p>
                <p>This website is possible because of <a href="#" target="_blank">Flickr</a></p>
                <p>Created by <a href="https://twitter.com/latiosaxe" id="myTwitter" target="_blank">@latiosaxe</a></p>
                <p>
                    <a target="_blank" href="https://www.amazon.com/b?_encoding=UTF8&tag=photogra0e0eb-20&linkCode=ur2&linkId=8488a1730f346d2169341c9b978e32e4&camp=1789&creative=9325&node=3017941">Do you want your own DSLR?</a><img src="//ir-na.amazon-adsystem.com/e/ir?t=photogra0e0eb-20&l=ur2&o=1" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
                </p>
            </div>
            <div class="half">
                <p>
                    <a href="/terms">Terms and Conditions</a>
                </p>
                <p>
                    <a href="/privacy">Privacy policy</a>
                </p>
            </div>
        </div>
    </footer>
</div>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="  crossorigin="anonymous"></script>
<script src="/assets/scripts/main.js"></script>
@yield('scripts')
</body>
</html>
var API_FLICKR_KEY = '0c72858bd7b4baffff57ab50e7a2f349',
    GlobalAdd = '';


var amazonBanners = [
    '<iframe style="width:120px;height:240px;" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="//ws-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&OneJS=1&Operation=GetAdHtml&MarketPlace=US&source=ac&ref=tf_til&ad_type=product_link&tracking_id=photogra0e0eb-20&marketplace=amazon&region=US&placement=B00IB1BTWI&asins=B00IB1BTWI&linkId=870a6c8386ec40fead2653063c207502&show_border=true&link_opens_in_new_window=true&price_color=333333&title_color=0066c0&bg_color=ffffff"> </iframe>',
    '<iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=8&l=ez&f=ifr&linkID=603ba085b12e1021cac9a8228c0426e3&t=photogra0e0eb-20&tracking_id=photogra0e0eb-20" width="120" height="240" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>'
], actualBanner = 0
    ;

$(document).ready(function () {

    if($(window).width <= 800){
           GlobalAdd = '<ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-4124457392679487" data-ad-slot="6424442163"></ins>';
        // GlobalAdd = '<ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8170975977203848" data-ad-slot="9309625804"></ins><script> (adsbygoogle = window.adsbygoogle || []).push({});</script>';
    }else{
           GlobalAdd = '<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-4124457392679487" data-ad-slot="6016058684"></ins>';
        // GlobalAdd = '<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-8170975977203848" data-ad-slot="2220283900"></ins><script> (adsbygoogle = window.adsbygoogle || []).push({});</script>';
    }

    $(".site .categories ul li, .site header .relative .popular ul li").on('click', function(){
        _makeSearch($(this).find('span').data('search'));
    });


    $(".site").delegate('.result-list li .photo', 'click', function (event) {
        event.preventDefault();
        _ownerPhoto($(this).data('id'));
    });
    $(".site").delegate('.overlay .close', 'click', function (event) {
        event.preventDefault();
        $("#killMePlease").fadeOut(300);
        setTimeout(function () {
            $("#killMePlease").remove();
        }, 350);
    });

    $(".site").delegate('.result-list li .vote', 'click', function (event) {
        event.preventDefault();
        var photoID = $(this).closest('li').find('.photo').data('id');
        $.ajax({
            method: 'GET',
            url: 'https://www.flickr.com/services/rest',
            data: {
                method: 'flickr.photos.getInfo',
                api_key: API_FLICKR_KEY,
                photo_id: photoID,
                nojsoncallback: 1,
                format: 'json'
            }
        }).done(function(dataAjax) {
            var info = dataAjax.photo;
            console.log(info);

            var tagsArray = [];

            $.each(info.tags.tag, function (index, value) {
               tagsArray.push(value.raw);
            });
            console.log(tagsArray);

            var data = {
                photo_id: photoID,
                title: info.title._content,
                description: info.description._content,
                photo: 'https://farm'+info.farm+'.staticflickr.com/'+info.server+'/'+info.id+'_'+info.secret+'_b.jpg+',
                category: tagsArray,
                user_name: info.owner.realname,
                user_nickname: info.owner.username,
                user_location: info.owner.location,
                user_profile: info.urls.url[0]._content
            };

            var _token =  $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token
                }
            });
            $.ajax({
                url: '/new_vote',
                data: data,
                type: 'post',
                success: function (data){
                    console.log(data);
                },
                error: function (err){
                    console.log(err.responseText);
                }
            });
            // done(function(data){
            //     console.log(data);
            // }).error(function(data){
            //     console.log(data);
            // });
        });

    });

    $(".GA_SEARCH_EVENT").on('submit', function () {
        var argument = $("#globalInputSearch").val();
        ga('send', 'event', 'Search', 'Header', argument.toLowerCase());
    });
    $(".GA_HOME_SEARCH_EVENT").on('submit', function () {
        var argument = $("#homeInputSearch").val();
        ga('send', 'event', 'Search', 'Home', argument.toLowerCase());
    });

    $("#myTwitter").on('click', function () {
        ga('send', 'event', 'Click', 'Twitter', '@latiosaxe');
    });


});

var _generateResurlts = function (argumentm, limit) {
    $.ajax({
        method: 'GET',
        url: 'https://www.flickr.com/services/rest',
        data: {
            method: 'flickr.photos.search',
            api_key: API_FLICKR_KEY,
//                text: 'surf',
            tags: argument,
            sort: 'relevance',
            searchResult_type: 1,  //Only photos
            format: 'json',
            nojsoncallback: 1,
            per_page: limit
        }
    }).done(function(data) {
        console.log(data);

        $("#searchResult").html('<div class="resume-search"><div class="container"><p>Results to the search: <strong>'+argument+'</strong></p></div></div>');
        $("#searchResult").append('<ul class="result-list"></ul>');

        $.each(data.photos.photo, function (index, value) {
            if(actual_add_position == (limit_add)){
                // $("#searchResult .result-list").append('<li class="add leaderboard"><div class="center">'+ GlobalAdd +'</div></li>');
                $("#searchResult .result-list").append('<li class="amazon-iframe"> '+ amazonBanners[actualBanner] +'</li>');
                actualBanner ++;
                if(actualBanner >= ( amazonBanners.length)){
                    actualBanner = 0;
                }
                actual_add_position = -4;
            }else{
                $("#searchResult .result-list").append('' +
                    '<li>' +
                        '<div class="vote">' +
                            '<div class="vote-icon normal"></div>'+
                        '</div>'+
                        '<img colorify src="https://farm'+value.farm+'.staticflickr.com/'+value.server+'/'+value.id+'_'+value.secret+'_b.jpg" id="imageData">'+
                        // '<a class="photo" data-id="'+ value.id +'" href="https://www.flickr.com/photos/'+value.owner+'/'+ value.id+'" target="_blank" style="background-image: url(https://farm'+value.farm+'.staticflickr.com/'+value.server+'/'+value.id+'_'+value.secret+'_b.jpg+)">' +
                        '<p>' +
                        ''+value.title+'' +
                        //                                    '<img src="https://s.yimg.com/pw/images/buddyicon09.png#'+value.owner+'" alt="" class="avatar">'+
                        '</p>' +
                        '</a>' +
                        '<a href="https://www.flickr.com/photos/'+value.owner+'/" class="author" target="_blank"><p>Owner</p></a>'+
                    '</li>' +
                    '');
            }
            actual_add_position ++;

            var img = document.getElementById("imageData");
            _checkColor(img);
            img.remove();
        });
        // (adsbygoogle = window.adsbygoogle || []).push({});
    });
};

var _makeSearch = function _makeSearch(argument) {
    $(".site header .relative form #globalInputSearch").val(argument);
    $(".site header .relative form").submit();
};


var _ownerPhoto = function _ownerPhoto(argument) {
    console.log(argument);
    $.ajax({
        method: 'GET',
        url: 'https://www.flickr.com/services/rest',
        data: {
            method: 'flickr.photos.getInfo',
            api_key: API_FLICKR_KEY,
            photo_id: argument,
            nojsoncallback: 1,
            format: 'json'
        }
    }).done(function(data) {
        var info = data.photo;
        console.log(info);

        var name = '';
        if(info.owner.realname){
            name = info.owner.realname;
        }else{
            name = info.owner.username;
        }

        var location = '';
        if(info.owner.location){
            location = '<p class="table">Location: <span id="location">'+info.owner.location+'</span></p>';
        }

        $(".site").append('' +
        '<div id="killMePlease" class="overlay">' +
            '<div class="close">X</div>' +
            '<div class="content">' +
                '<div class="image"  style="background-image: url(https://farm'+info.farm+'.staticflickr.com/'+info.server+'/'+info.id+'_'+info.secret+'_b.jpg+)"></div>' +
                '<div class="meta">' +
                    '<div class="title" id="title">'+info.title._content+'</div>' +
                    '<div class="description" id="description">'+info.description._content+'</div>' +
                    '<hr/>'+
                    '<p class="table">User: <span id="realname">'+ name +'</span></p>' +
                    location +
                    '<ul id="tags"></ul>' +
                    '<p><a href="'+info.urls.url[0]._content+'" id="urlTarget" target="_blank" class="btn">View original</a></p>' +
                    '</div>' +
            '</div>' +
        '</div>');
    });
};

var _checkColor = function _checkColor(img){
    var colors = getColors(draw(img));
    for (var hex in colors) {
        console.log( pad(hex) + "->" + colors[hex]);
    }

    function draw(img) {
        var canvas = document.createElement("canvas");
        var c = canvas.getContext('2d');
        c.width = canvas.width = img.width;
        c.height = canvas.height = img.height;
        c.clearRect(0, 0, c.width, c.height);
        c.drawImage(img, 0, 0, img.width , img.height);
        return c; // returns the context
    }

    function getColors(c) {
        console.log(c);
        var col, colors = {};
        var pixels, r, g, b, a;
        r = g = b = a = 0;
        pixels = c.getImageData(0, 0, c.width, c.height);
        for (var i = 0, data = pixels.data; i < data.length; i += 4) {
            r = data[i];
            g = data[i + 1];
            b = data[i + 2];
            a = data[i + 3]; // alpha
            // skip pixels >50% transparent
            if (a < (255 / 2))
                continue;
            col = rgbToHex(r, g, b);
            if (!colors[col])
                colors[col] = 0;
            colors[col]++;
        }
        return colors;
    }

    function rgbToHex(r, g, b) {
        if (r > 255 || g > 255 || b > 255)
            throw "Invalid color component";
        return ((r << 16) | (g << 8) | b).toString(16);
    }

// nicely formats hex values
    function pad(hex) {
        return ("000000" + hex).slice(-6);
    }

};

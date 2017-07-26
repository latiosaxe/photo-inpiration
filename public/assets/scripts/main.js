var API_FLICKR_KEY = '0c72858bd7b4baffff57ab50e7a2f349',
    GlobalAdd = '';

$(document).ready(function () {
    if($(window).width <= 800){
           GlobalAdd = '<ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-4124457392679487" data-ad-slot="6424442163"></ins><script> (adsbygoogle = window.adsbygoogle || []).push({});</script>';
        // GlobalAdd = '<ins class="adsbygoogle" style="display:inline-block;width:300px;height:250px" data-ad-client="ca-pub-8170975977203848" data-ad-slot="9309625804"></ins><script> (adsbygoogle = window.adsbygoogle || []).push({});</script>';
    }else{
           GlobalAdd = '<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-4124457392679487" data-ad-slot="6016058684"></ins><script> (adsbygoogle = window.adsbygoogle || []).push({});</script>';
        // GlobalAdd = '<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-8170975977203848" data-ad-slot="2220283900"></ins><script> (adsbygoogle = window.adsbygoogle || []).push({});</script>';
    }

    $(".site .categories ul li, .site header .relative .popular ul li").on('click', function(){
        _makeSearch($(this).find('span').data('search'));
    });


    $(".site").delegate('.result-list li .photo', 'click', function (event) {
        event.preventDefault();
        _ownerPhoto($(this).data('id'));
    })
    $(".site").delegate('.overlay .close', 'click', function (event) {
        event.preventDefault();
        $("#killMePlease").fadeOut(300);
        setTimeout(function () {
            $("#killMePlease").remove();
        }, 350);
    })
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
                $("#searchResult .result-list").append('<li class="add leaderboard"><div class="center">'+ GlobalAdd +'</div></li>');
                actual_add_position = -1;
            }else{
                $("#searchResult .result-list").append('' +
                    '<li>' +
                    '<a class="photo" data-id="'+ value.id +'" href="https://www.flickr.com/photos/'+value.owner+'/'+ value.id+'" target="_blank" style="background-image: url(https://farm'+value.farm+'.staticflickr.com/'+value.server+'/'+value.id+'_'+value.secret+'_b.jpg+)">' +
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
        })
    });
};

var _makeSearch = function _makeSearch(argument) {
    console.log(argument);
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
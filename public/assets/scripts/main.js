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

    $(".site").delegate('.searchByColor', 'click', function (event) {
        location.href = "/color/"+$(this).data('color');
        // var data = {'color': $(this).data('color')};
        // var _token =  $('meta[name="csrf-token"]').attr('content');
        // $.ajax({
        //     url: '/searchByColor',
        //     data: data,
        //     type: 'post',
        //     beforeSend: function (xhr, type) {
        //         if (type.type !== "GET") {
        //             xhr.setRequestHeader('X-CSRF-TOKEN', _token);
        //         }
        //     },
        //     success: function (data){
        //         console.log(data);
        //     },
        //     error: function (err){
        //         console.log(err.responseText);
        //     },
        //     done: function () {
        //         $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN': ''
        //             }
        //         });
        //     }
        // });
    });
    $(".site").delegate('#searchByColor', 'click', function () {
        location.href = $(this).data('color');
    });

    $(".site").delegate('.result-list li .vote, .color_photo_grid .single .vote', 'click', function (event) {
        event.preventDefault();
        var _$this = $(this);
        var photoID = _$this.closest('.wrapper').find('.photo').data('id');
        _$this.addClass('loadingVote');
        console.log(photoID);
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
            // $.each(info.tags.tag, function (index, value) {
            //    tagsArray.push(value.raw);
            // });
            console.log(tagsArray);

            var data = {
                photo_id: photoID,
                title: info.title._content,
                description: info.description._content,
                photo: 'https://farm'+info.farm+'.staticflickr.com/'+info.server+'/'+info.id+'_'+info.secret+'_b.jpg',
                // category: tagsArray,
                user_name: info.owner.realname,
                user_nickname: info.owner.username,
                user_location: info.owner.location,
                user_profile: info.urls.url[0]._content
            };

            var _token =  $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/new_vote',
                data: data,
                type: 'post',

                beforeSend: function (xhr, type) {
                    // Set the CSRF Token in the header for security
                    if (type.type !== "GET") {
                        xhr.setRequestHeader('X-CSRF-TOKEN', _token);
                    }
                },

                success: function (data){
                    console.log(data);
                    console.log(_$this);
                    _$this.addClass('active');
                    if(_$this.find('span').length > 0){
                        _$this.find('span').text( parseInt( _$this.find('span').text() , 10) + 1);
                    }
                    _$this.removeClass('loadingVote');
                    ga('send', 'event', 'Click', 'Like', photoID);
                },
                error: function (err){
                    console.log(err.responseText);
                },
                done: function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': ''
                        }
                    });
                }
            });
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
                    '<li class="wrapper" itemscope itemtype="http://schema.org/ImageObject">' +
                        '<div class="vote">' +
                            '<div class="vote-icon normal"></div>'+
                            '<div class="loading">'+
                                '<div class="bubble-1"></div>'+
                                '<div class="bubble-2"></div>'+
                            '</div>'+
                        '</div>'+
                        '<img style="visibility: hidden; height: 0; width: 0; position: absolute;" src="https://farm'+value.farm+'.staticflickr.com/'+value.server+'/'+value.id+'_'+value.secret+'_b.jpg" id="imageData" itemprop="contentUrl">'+
                        '<a class="photo" data-id="'+ value.id +'" href="https://www.flickr.com/photos/'+value.owner+'/'+ value.id+'" target="_blank" style="background-image: url(https://farm'+value.farm+'.staticflickr.com/'+value.server+'/'+value.id+'_'+value.secret+'_b.jpg+)">' +
                        '<p itemprop="description">' +
                            ''+value.title+'' +
                        '</p>' +
                        '</a>' +
                        // '<a href="https://www.flickr.com/photos/'+value.owner+'/" class="author" target="_blank"><p>Owner</p></a>'+
                    '</li>' +
                    '');
            }
            actual_add_position ++;
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




function rgbToHsv(r, g, b) {
    if (arguments.length === 1) {
        g = r.g, b = r.b, r = r.r;
    }
    var max = Math.max(r, g, b), min = Math.min(r, g, b),
        d = max - min,
        h,
        s = (max === 0 ? 0 : d / max),
        v = max / 255;

    switch (max) {
        case min: h = 0; break;
        case r: h = (g - b) + d * (g < b ? 6: 0); h /= 6 * d; break;
        case g: h = (b - r) + d * 2; h /= 6 * d; break;
        case b: h = (r - g) + d * 4; h /= 6 * d; break;
    }

    return [
        h,
        s,
        v
    ];
}

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function rgbToHsl(rgbArr){
    var r1 = rgbArr[0] / 255;
    var g1 = rgbArr[1] / 255;
    var b1 = rgbArr[2] / 255;

    var maxColor = Math.max(r1,g1,b1);
    var minColor = Math.min(r1,g1,b1);
    //Calculate L:
    var L = (maxColor + minColor) / 2 ;
    var S = 0;
    var H = 0;
    if(maxColor != minColor){
        //Calculate S:
        if(L < 0.5){
            S = (maxColor - minColor) / (maxColor + minColor);
        }else{
            S = (maxColor - minColor) / (2.0 - maxColor - minColor);
        }
        //Calculate H:
        if(r1 == maxColor){
            H = (g1-b1) / (maxColor - minColor);
        }else if(g1 == maxColor){
            H = 2.0 + (b1 - r1) / (maxColor - minColor);
        }else{
            H = 4.0 + (r1 - g1) / (maxColor - minColor);
        }
    }

    L = L * 100;
    S = S * 100;
    H = H * 60;
    if(H<0){
        H += 360;
    }
    var result = [H, S, L];
    return result;
}

function rgbToHex(red, green, blue) {
    var rgb = blue | (green << 8) | (red << 16);
    return '#' + (0x1000000 + rgb).toString(16).slice(1);
}



function isPercentage(n) {
    return typeof n === "string" && n.indexOf('%') != -1;
}

function isOnePointZero(n) {
    return typeof n == "string" && n.indexOf('.') != -1 && parseFloat(n) === 1;
}

function bound01(n, max) {
    if (isOnePointZero(n)) { n = "100%"; }

    var processPercent = isPercentage(n);
    n = Math.min(max, Math.max(0, parseFloat(n)));

    // Automatically convert percentage into number
    if (processPercent) {
        n = parseInt(n * max, 10) / 100;
    }

    // Handle floating point rounding errors
    if ((Math.abs(n - max) < 0.000001)) {
        return 1;
    }

    // Convert into [0, 1] range if it isn't already
    return (n % max) / parseFloat(max);
}

function hslToRgb(h, s, l) {
    var r, g, b;

    h = bound01(h, 360);
    s = bound01(s, 100);
    l = bound01(l, 100);

    function hue2rgb(p, q, t) {
        if(t < 0) t += 1;
        if(t > 1) t -= 1;
        if(t < 1/6) return p + (q - p) * 6 * t;
        if(t < 1/2) return q;
        if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
        return p;
    }

    if(s === 0) {
        r = g = b = l; // achromatic
    }
    else {
        var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
        var p = 2 * l - q;
        r = hue2rgb(p, q, h + 1/3);
        g = hue2rgb(p, q, h);
        b = hue2rgb(p, q, h - 1/3);
    }

    return [r * 255, g * 255, b * 255];
}

function rgbToHsl(rgbArr) {
    var r1 = rgbArr[0] / 255;
    var g1 = rgbArr[1] / 255;
    var b1 = rgbArr[2] / 255;

    var maxColor = Math.max(r1,g1,b1);
    var minColor = Math.min(r1,g1,b1);
    //Calculate L:
    var L = (maxColor + minColor) / 2 ;
    var S = 0;
    var H = 0;
    if (maxColor != minColor) {
        //Calculate S:
        if (L < 0.5) {
            S = (maxColor - minColor) / (maxColor + minColor);
        } else {
            S = (maxColor - minColor) / (2.0 - maxColor - minColor);
        }
        //Calculate H:
        if(r1 == maxColor) {
            H = (g1-b1) / (maxColor - minColor);
        } else if (g1 == maxColor) {
            H = 2.0 + (b1 - r1) / (maxColor - minColor);
        } else {
            H = 4.0 + (r1 - g1) / (maxColor - minColor);
        }
    }

    L = L * 100;
    S = S * 100;
    H = H * 60;
    if(H<0){
        H += 360;
    }
    var result = [H, S, L];
    return result;
}

function isWindow(obj) {
    return obj !== null && obj === obj.window;
}

function getWindow(elem) {
    return isWindow(elem) ? elem : elem.nodeType === 9 && elem.defaultView;
}

function offset(elem) {

    var docElem, win,
        box = {
            top: 0,
            left: 0
        },
        doc = elem && elem.ownerDocument;

    docElem = doc.documentElement;

    if (typeof elem.getBoundingClientRect !== typeof undefined) {
        box = elem.getBoundingClientRect();
    }
    win = getWindow(doc);
    return {
        top: box.top + win.pageYOffset - docElem.clientTop,
        left: box.left + win.pageXOffset - docElem.clientLeft
    };
}

function segmentNumber(number, min, max) {
    return Math.max(min, Math.min(number, max));
}


// COLOR PICKER //---------------//


var color = [0, 100, 50];
var elements = {
    hue_bar: document.querySelector(".hue_bar"),
    sat_rect: document.querySelector(".sat_rect"),
    color_preview: document.querySelector(".color_preview"),
    sat_picker: document.querySelector(".sat_picker"),
    hue_picker: document.querySelector(".hue_picker"),
    background_div: document.getElementById("searchByColor")
};
var clickBtn = document.getElementById('searchByColor');

var sat_width = elements.sat_rect.offsetWidth,
    sat_height = elements.sat_rect.offsetHeight;
var hue_height = elements.hue_bar.offsetHeight;

function returnPickedColor() {
    elements.hue_picker.style.background = "hsl( " + color[0] + ",100%, 50% )";
    // elements.background_div.style.background = "hsl( " + color[0] + "," + color[1] + "%," + color[2] + "% )";
    elements.sat_picker.style.background = "hsl( " + color[0] + "," + color[1] + "%," + color[2] + "% )";
    elements.color_preview.style.background = "hsl( " + color[0] + "," + color[1] + "%," + color[2] + "% )";
    var rgb_color = hslToRgb(color[0], color[1], color[2]),
        hex_color = rgbToHex(rgb_color[0], rgb_color[1], rgb_color[2]);
    console.log(hex_color);
    console.log(rgb_color);
    document.querySelector(".bottom input").value = hex_color.toUpperCase();
    clickBtn.disabled = false;
    clickBtn.setAttribute("data-color", "/color/"+ Math.floor(rgb_color[0]) +"-"+ Math.floor(rgb_color[1]) +"-"+ Math.floor(rgb_color[2]));
}

// function componentToHex(c) {
//     var hex = c.toString(16);
//     return hex.length == 1 ? "0" + hex : hex;
// }
//
// function rgbToHex(r, g, b) {
//     return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
// }

function setHuePickerValue(e) {
    var hue_bar_position = {
        top: offset(elements.sat_rect).top
    };
    color[0] = segmentNumber(Math.floor((((e.pageY - hue_bar_position.top) / hue_height) * 360)), 0, 360);
    elements.hue_picker.style.top = segmentNumber(((e.pageY - hue_bar_position.top) / hue_height) * 100, 0, hue_height / 2) + "%";
    elements.sat_rect.style.background = "hsl(" + color[0] + ", 100%, 50%)";
    returnPickedColor();
}

var hue_drag_started = false,
    sat_drag_started = false;

//LINE DRAG START
elements.hue_bar.addEventListener('mousedown', function(e) {
    hue_drag_started = true;
    elements.hue_picker.classList.add("active");

    setHuePickerValue(e);
});

//---------------------------------//

function setSatPickerValue(e) {

    var rect_position = {
        left: offset(elements.sat_rect).left,
        top: offset(elements.sat_rect).top
    };

    var position = [
        segmentNumber(e.pageX - rect_position.left, 0, sat_width),
        segmentNumber(e.pageY - rect_position.top, 0, sat_height)
    ];

    elements.sat_picker.style.left = position[0] + "px";
    elements.sat_picker.style.top = position[1] + "px";

    color[1] = Math.floor(((position[0] / sat_width) * 100));

    var x = e.pageX - offset(elements.sat_rect).left;
    var y = e.pageY - offset(elements.sat_rect).top;
    //constrain x max
    if (x > sat_width) {
        x = sat_width;
    }
    if (x < 0) {
        x = 0;
    }
    if (y > sat_height) {
        y = sat_height;
    }
    if (y < 0) {
        y = 0;
    }

    //convert between hsv and hsl
    var xRatio = x / sat_width * 100,
        yRatio = y / sat_height * 100,
        hsvValue = 1 - (yRatio / 100),
        hsvSaturation = xRatio / 100,
        lightness = (hsvValue / 2) * (2 - hsvSaturation);

    color[2] = Math.floor(lightness * 100);

    returnPickedColor();
}

//COLOR DRAG START
elements.sat_rect.addEventListener('mousedown', function(e) {
    sat_drag_started = true;

    elements.sat_picker.classList.add("active");
    setSatPickerValue(e);
});

document.addEventListener('mousemove', function(e) {
    //COLOR DRAG MOVE
    if (sat_drag_started) {
        setSatPickerValue(e);
    }

    //LINE DRAG MOVE
    if (hue_drag_started) {
        setHuePickerValue(e);
    }
});

//MOUSE UP
document.addEventListener('mouseup', function() {
    if (sat_drag_started) {
        elements.sat_picker.classList.remove("active");
        sat_drag_started = false;
    }

    if (hue_drag_started) {
        elements.hue_picker.classList.remove("active");
        hue_drag_started = false;
    }
});

function changeHex(hex_val) {
    var rgb_val = hexToRgb(hex_val);
    if (rgb_val !== null) {
        var hsl_val = rgbToHsl([rgb_val.r,rgb_val.g,rgb_val.b]),
            hsv_val = rgbToHsv(rgb_val.r,rgb_val.g,rgb_val.b);
        color[0] = hsl_val[0];
        elements.sat_rect.style.background = "hsl(" + color[0] + ", 100%, 50%)";
        elements.hue_picker.style.top = hsl_val[0] / 360 * 100 + "%";
        elements.hue_picker.style.background = "hsl("+hsl_val[0]+", 100%, 50%)";
        elements.sat_picker.style.background = hex_val;
        document.querySelector(".color_preview").style.background = hex_val;
        elements.sat_picker.style.left = hsl_val[1] + "%";
        elements.sat_picker.style.top = 100 - ( hsv_val[2] * 100 ) + "%";

    }
}




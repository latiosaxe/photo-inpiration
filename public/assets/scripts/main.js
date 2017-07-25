$(document).ready(function () {
    $(".site .categories ul li").on('click', function(){
        _makeSearch($(this).find('span').data('search'));
    });
});

var _makeSearch = function _makeSearch(argument) {
    console.log(argument);
    $(".site header .relative form #globalInputSearch").val(argument);
    $(".site header .relative form").submit();
};
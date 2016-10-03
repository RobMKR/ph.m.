$(function() {
    var header = '.toggleHeader';
    var menu = 'ul.toggle';
    var menuHandler = '.menuHandler';

    $(header).click(function () {
        $(this).next(menu).toggle();
    });

    $(menuHandler).change(function () {
        var menuBlock = $(this).parents('.toggleBlock');
        var inputs = menuBlock.find('.toggleLi input[type="checkbox"]');
        if($(this).is(':checked')){
            inputs.prop('checked', true);
            menuBlock.find('ul.toggle').show();
        }else{
            inputs.prop('checked', false);
        }
    });

    $('.toggleLi input').change(function() {
        if(!$(this).is(':checked')){
            $(this).parents('.toggleBlock').find('.menuHandler').prop('checked', false);
        }
    } );

});
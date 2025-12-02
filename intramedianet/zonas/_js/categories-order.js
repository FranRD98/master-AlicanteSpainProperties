$(document).ready(function() {

    $('.dd').nestable({
        group: 1
    }).on('change', function() {
        var order = window.JSON.stringify($('.dd').nestable('serialize'));
        $('.loading-ord').show();
        $.get("categories_order.php?json="+order, function(data) {
            $('.loading-ord').fadeOut();
        });
    });

});
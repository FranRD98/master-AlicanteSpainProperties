jQuery(document).ready(function($) {

    $('#cats').select2().change(function(e) {
        $.ajax({
            type: "GET",
            url: "users-num.php?cats="+$(this).val()+"&lang="+$('#langs').val(),
            cache: false
        }).done(function( data ) {
            $('.total-users').html(data);
        });
    });

    $('#langs').change(function(e) {
        $('#cats').select2().change();
        $.ajax({
            type: "GET",
            url: "news-list.php?lang="+$(this).val(),
            cache: false
        }).done(function( data ) {
            $('#news_chzn').width();
            $('#news_chzn').remove();
            $('#news').removeClass('chzn-done');
            $('#news').html(data).select2();
        });
    });

    $('#form1').submit(function(e) {
        e.preventDefault();
        if ($(this).valid()) {
            $('.progess').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button>' + newsletterMens1 + '</div>');
            $.ajax({
                type: "GET",
                url: "send.php?"+$(this).serialize(),
                cache: false
            }).done(function( data ) {
                if (data == 'ok') {
                    $('.progess').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>' + newsletterMens2 + '</div>');
                }
            });
        }
    });

});
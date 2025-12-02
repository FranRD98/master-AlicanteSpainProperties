jQuery(document).ready(function($) {

    $("#schedule").click(function(e){
        $("#schedule_ct").attr("disabled",!$("#schedule").prop('checked'));
    });

    $('.datetimepicker').datetimepicker({
        lang: AppLang,
        format:'d-m-Y H:i',
        step: 15,
    });

    $('#form1').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $('.progess').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button>' + mailchimpMens1 + '</div>');

            $.ajax({
                type: "GET",
                url: "send.php?"+$(this).serialize(),
                cache: false
            }).done(function( data ) {

                if (data == 'ok') {

                    $('.progess').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>' + mailchimpmens2 + '</div>');

                }

            });

        }

    });

});
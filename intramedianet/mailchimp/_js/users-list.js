jQuery(document).ready(function($) {

    $('.delete-user').click( function(e) {

        e.preventDefault();

        var btn = $(this);

        if (confirm(mailchimpDelUser)) {

            $.post('del-user.php', {

                lista: listID,
                email: btn.data('email'),
                euid: btn.data('euid'),
                leid: btn.data('leid')

            }, function(data) {

                if (data == '1') {

                    btn.parent().parent().fadeOut('fast', function() { $(this).remove(); })

                }

            });

        }

    });

});
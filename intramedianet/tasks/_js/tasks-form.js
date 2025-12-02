jQuery( document ).ready(function( $ ) {

    $('#contact_tsk').change(function(event) {

        var val = $('#contact_type_tsk').val();

        if (val == 1) {
            $.get( "contacts_email.php?id=" + $(this).val(), function( data ) {
                if (data != '') {
                    $( ".emailc" ).html( '<div>' + data + '</div>' );
                } else {
                    $( ".emailc" ).html( '' );
                }
            });
            $.get( "contacts_phone.php?id=" + $(this).val(), function( data ) {
                if (data != '') {
                    $( ".phonec" ).html( '<div>' + data + '</div>' );
                } else {
                    $( ".phonec" ).html( '' );
                }
            });
        }

        if (val == 2) {
            $.get( "buyers_email.php?id=" + $(this).val(), function( data ) {
                if (data != '') {
                    $( ".emailc" ).html( '<div>' + data + '</div>' );
                } else {
                    $( ".emailc" ).html( '' );
                }
            });
            $.get( "buyers_phone.php?id=" + $(this).val(), function( data ) {
                if (data != '') {
                    $( ".phonec" ).html( '<div>' + data + '</div>' );
                } else {
                    $( ".phonec" ).html( '' );
                }
            });
        }

        if (val == 3) {
            $.get( "owners_email.php?id=" + $(this).val(), function( data ) {
                if (data != '') {
                    $( ".emailc" ).html( '<div>' + data + '</div>' );
                } else {
                    $( ".emailc" ).html( '' );
                }
            });
            $.get( "owners_phone.php?id=" + $(this).val(), function( data ) {
                if (data != '') {
                    $( ".phonec" ).html( '<div>' + data + '</div>' );
                } else {
                    $( ".phonec" ).html( '' );
                }
            });
        }

    });

    $('#contact_type_tsk').change(function(event) {

        var val = $(this).val();

        $( ".emailc" ).html( '' );
        $( ".phonec" ).html( '' );

        if (val == 1) {
            $.get( "contacts.php?tip=" + tip + "&sel=" + sel, function( data ) {
                $( "#contact_tsk" ).html( data ).change();
            });
        }

        if (val == 2) {
            $.get( "buyers.php?tip=" + tip + "&sel=" + sel, function( data ) {
                $( "#contact_tsk" ).html( data ).change();
            });
        }

        if (val == 3) {
            $.get( "owners.php?tip=" + tip + "&sel=" + sel, function( data ) {
                $( "#contact_tsk" ).html( data ).change();
            });
        }

    }).change();

});
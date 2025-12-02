$(document).ready(function() {

    $('#startImport').click(function (){

        if (confirm(agreeXML)) {

            $('#importiframe').attr('src', 'import-loading.php');
            setTimeout(function() { $('#importiframe').attr('src', 'import-start.php?p='+$('#site_xml').val()); }, 5000);
            $('#portaiframe').fadeIn('slow');

        }

    });


});
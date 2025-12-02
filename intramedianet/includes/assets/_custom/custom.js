//  ============================================================================
//  === Header fixed
//  ============================================================================

$(window).scroll(function() {
    if ($(this).scrollTop() > 153){
        $('.card-header-fix').addClass("sticky");
    }
    else{
        $('.card-header-fix').removeClass("sticky");
    }
});

//  ============================================================================
//  === Header fixed tabs
//  ============================================================================

$(window).scroll(function() {
    if ($(this).scrollTop() > 120){
        $('#tabs-header-fix').addClass("sticky");
    }
    else{
        $('#tabs-header-fix').removeClass("sticky");
    }
});

//  ============================================================================
//  === Scrollbar check
//  ============================================================================
jQuery.fn.hasHScrollBar = function()
{
    return this.get(0).scrollWidth > this.innerWidth();
};

function toggleScrollBarIcon() {
    if ($('.table-responsive').length) {
        if ( $('.table-responsive').hasHScrollBar() ) {
            if ( !$('.iconHscroll').length ) {
                $('.table-responsive').before('<div class="iconHscroll">' + scrollText + '</div>');
            }
        } else {
            $('.iconHscroll').remove();
        }
    }
}

//  ============================================================================
//  === jQuery Ready
//  ============================================================================

$(document).ready(function() {

    //  ============================================================================
    //  === Back to top
    //  ============================================================================

    $('#back-top').click(function(e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    //  ============================================================================
    //  === Datetimepicker
    //  ============================================================================

    if (applang == 'es') {
        $(".datepicktime").flatpickr({
            enableTime: true,
            time_24hr: true,
            locale: "es",
            dateFormat: "d-m-Y H:i"
        });
    } else {
        $(".datepicktime").flatpickr({
            enableTime: true,
            time_24hr: true,
            dateFormat: "d-m-Y H:i"
        });
    }

    //  ============================================================================
    //  === Traducción de textos
    //  ============================================================================

    $('.btn-translate').click(function(e) {
        e.preventDefault();
        from = $(this).data('from');
        langFrom = from;
        if( from == "se"){
            langFrom = "sv";
        }
        to = $(this).data('to');
        langTo = to;
        if( to == "se"){
            langTo = "sv";
        }
        pref = $(this).data('fields-pref');
        suf = $(this).data('fields-suf');
        tab = $(this).data('tab');
        from_field = $('#' + pref + '' + from + '' + suf);
        to_field = '#' + pref + '' + to + '' + suf;
        tab = '#' + tab + '' + to;
        prefijo = pref;
        if (prefijo == 'descripcion_' || prefijo == 'bio_' || prefijo == 'content_') {
            from_field_val = $(from_field).redactor('source.getCode');
        } else {
            from_field_val = from_field.val();
        }
        if (from_field_val != '') {
            $.post('/_herramientas/translate.php', { text: from_field_val, from: langFrom, to: langTo, to_field: to_field, prefijo: prefijo, tab: tab }, function(data) {
                if (data != '') {
                    if (prefijo == 'descripcion_' || prefijo == 'bio_' || prefijo == 'content_') {
                        $(to_field).redactor('source.setCode', data);
                    } else {
                        $(to_field).val(data).keyup();
                    }
                    $(tab).click();
                }
            });
        }
    });

    //  ============================================================================
    //  === Videos Add
    //  ============================================================================

    $('#addVid').click(function (e){
        tb = $(this);
        e.preventDefault();
        if($('#video').val() != ''){
            $.get('videos_add.php', { p: tb.attr('data-id'), vid: $('#video').val() }, function(data) {
                $('#videos-list').append(data);
                $('#video').val('');
            });
        }
    });

    //  ============================================================================
    //  === Videos Order
    //  ============================================================================

    var nestedSortablesVideo = [].slice.call(document.querySelectorAll('.nested-sortable-video'));
    if (nestedSortablesVideo) {
        Array.from(nestedSortablesVideo).forEach(function (nestedSortVideo){
            sortableVid = new Sortable(nestedSortVideo, {
                // handle: '.handle',
                // group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onUpdate: function (evt) {
                var order = sortableVid.toArray();
                $('#video-order-loading').css({ width: $('#videos-list').outerWidth(), height: $('#videos-list').outerHeight() + 5 }).fadeIn();
                    $.get("videos_order.php?order="+order, function(data) {
                        $('#video-order-loading').fadeOut();
                    });
                }
            });
        });
    }

    //  ============================================================================
    //  === 360 Order
    //  ============================================================================

    var nestedSortablesVideo = [].slice.call(document.querySelectorAll('.nested-sortable-tressesenta'));
    if (nestedSortablesVideo) {
        Array.from(nestedSortablesVideo).forEach(function (nestedSortVideo){
            sortable360 = new Sortable(nestedSortVideo, {
                // handle: '.handle',
                // group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onUpdate: function (evt) {
                var order = sortable360.toArray();
                $('#tressesenta-order-loading').css({ width: $('#tressesenta-list').outerWidth(), height: $('#tressesenta-list').outerHeight() + 5 }).fadeIn();
                    $.get("360_order.php?order="+order, function(data) {
                        $('#tressesenta-order-loading').fadeOut();
                    });
                }
            });
        });
    }

    //  ============================================================================
    //  === Videos Delete
    //  ============================================================================

    $(document).on('click', '.del-vid', function(e) {
        e.preventDefault();

        tb = $(this);
        vid = tb.attr('href');

        Swal.fire({
            title: delRecord,
            text: delRecord2,
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success w-xs me-2 mt-2',
            cancelButtonClass: 'btn btn-danger w-xs mt-2',
            confirmButtonText: delRecordYes,
            cancelButtonText: delRecordNo,
            buttonsStyling: false,
            showCloseButton: true
        }).then(function (result) {
            if (result.value) {
                 $.get(vid, { id: tb.attr('data-id') }, function(data) {
                     if(data == 'ok') {
                         tb.closest('li').fadeOut('slow', function() { $(this).remove(); });
                     }
                 });
            }
        });

        // if (confirm(delRecord)) {
        //     $.get(vid, { id: tb.attr('data-id') }, function(data) {
        //         if(data == 'ok') {
        //             tb.parent().parent().parent().fadeOut('slow', function() { $(this).remove(); });
        //         }
        //     });
        // }

        return false;

    });

    //  ============================================================================
    //  === Files Order
    //  ============================================================================

    var nestedSortablesFiles = [].slice.call(document.querySelectorAll('.nested-sortable-file'));
    if (nestedSortablesFiles) {
        Array.from(nestedSortablesFiles).forEach(function (nestedSortFiles){
            sortableFil = new Sortable(nestedSortFiles, {
                // handle: '.handle',
                // group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onUpdate: function (evt) {
                var order = sortableFil.toArray();
                $('#files-order-loading').css({ width: $('#file-list').outerWidth(), height: $('#file-list').outerHeight() + 5 }).fadeIn();
                    $.get("files_order.php?order="+order, function(data) {
                        $('#files-order-loading').fadeOut();
                    });
                }
            });
        });
    }

    //  ============================================================================
    //  === Files Delete
    //  ============================================================================

    $(document).on('click', '.del-fil', function(e) {
        e.preventDefault();

        tb = $(this);
        vid = tb.attr('href');

        Swal.fire({
            title: delRecord,
            text: delRecord2,
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success w-xs me-2 mt-2',
            cancelButtonClass: 'btn btn-danger w-xs mt-2',
            confirmButtonText: delRecordYes,
            cancelButtonText: delRecordNo,
            buttonsStyling: false,
            showCloseButton: true
        }).then(function (result) {
            if (result.value) {
                 $.get(vid, { id: tb.attr('data-id') }, function(data) {
                     if(data == 'ok') {
                         $('#' + tb.closest('li').attr('id')).fadeOut('slow', function() { $(this).remove(); });
                     }
                 });
            }
        });

        // if (confirm(delRecord)) {
        //     $.get(vid, { id: tb.attr('data-id') }, function(data) {
        //         if(data == 'ok') {
        //             tb.parent().parent().parent().fadeOut('slow', function() { $(this).remove(); });
        //         }
        //     });
        // }

        return false;

    });

    //  ============================================================================
    //  === Contar texto
    //  ============================================================================

    $('.textcountseo').textcounter({
        'countSpaces': true
    });

    //  ============================================================================
    //  === Redactor
    //  ============================================================================

    $(".wysiwyg").redactor({

        lang: applang,
        autoresize: false,
        multipleUpload: false,
        minHeight: '400px',
        maxHeight: '900px',
        removeComments: true,
        structure: true,
        source: {
            codemirror: {
                lineNumbers: true,
                mode: "htmlmixed",
                indentUnit: 4,
                matchBrackets: true,
                matchTags: true,
                autoCloseTags: true,
                indentWithTabs: true,
                theme: 'oceanic-next'
            }
        },
        removeEmpty: ['strong', 'em', 'span', 'p'],
        buttons: ['html', 'undo' ,'redo', 'format', 'bold', 'italic', 'deleted', 'sup', 'sub', 'lists', 'outdent', 'indent', 'image', 'link', 'line'],
        plugins: ['alignment', 'fontcolor', 'table', 'counter', 'video', 'fullscreen']
    });

    //  ============================================================================
    //  === Delete record from list
    //  ============================================================================

    $(document).on('click', '.delrow', function(e) {

        e.preventDefault();

        tb = $(this);

        Swal.fire({
            title: delRecord,
            text: delRecord2,
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success w-xs me-2 mt-2',
            cancelButtonClass: 'btn btn-danger w-xs mt-2',
            confirmButtonText: delRecordYes,
            cancelButtonText: delRecordNo,
            buttonsStyling: false,
            showCloseButton: true
        }).then(function (result) {
            if (result.value) {
                 window.location = ''+tb.attr('href')+'';
            }
        });

    });

    $(document).on('click', '.delrow2', function(e) {

        e.preventDefault();

        tb = $(this);

        Swal.fire({
            title: delRecord,
            text: delRecord2,
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success w-xs me-2 mt-2',
            cancelButtonClass: 'btn btn-danger w-xs mt-2',
            confirmButtonText: delRecordYes,
            cancelButtonText: delRecordNo,
            buttonsStyling: false,
            showCloseButton: true
        }).then(function (result) {
            if (result.value) {
                 window.location = window.location.href + '&KT_Delete1=1';
            }
        });

    });

    //  ============================================================================
    //  === Password generator
    //  ============================================================================

    $.extend({
        password: function (length, special) {
            var iteration = 0;
            var password = "";
            var randomNumber;
            if(special == undefined){
                var special = false;
            }
            while(iteration < length) {
                randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
                if(!special){
                    if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
                    if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
                    if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
                    if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
                }
                iteration++;
                password += String.fromCharCode(randomNumber);
            }
            return password;
        }
    });

    $('.pass-generator').click(function () {
        password = $.password(2, false) + "_" + $.password(2, false) + "6dY" + $.password(2, false) + "@";
        $('#password-input, #re_password_usr').val(password);
        $('#password-input').keyup();
        $('.password-view').text(password);
    });

    //  ============================================================================
    //  === Password strength meter
    //  ============================================================================

     $('#password-input').pwstrength({
        ui: {
            container: "#pwd-container",
            showVerdictsInsideProgressBar: false,
            showVerdicts: false,
            viewports: {
                progress: ".pwstrength_viewport_progress",
            },
            verdicts: [
                pasMalo,
                pasNormal,
                pasMedio,
                pasFuerte,
                pasMuyFuerte
            ]
        }
    });

    //  ============================================================================
    //  === Profile image preview
    //  ============================================================================

     if (document.querySelector("#profile-img-file-input")) {
         document.querySelector("#profile-img-file-input").addEventListener("change", function () {
             var preview = document.querySelector(".user-profile-image");
             var file = document.querySelector(".profile-img-file-input").files[0];
             var reader = new FileReader();
             reader.addEventListener(
                 "load",
                 function () {
                     preview.src = reader.result;
                 },
                 false
             );
             if (file) {
                 reader.readAsDataURL(file);
             }
         });
     }

     //  ============================================================================
     //  === Select2
     //  ============================================================================

     $(".select2").select2();

     //  ============================================================================
     //  === Images Order
     //  ============================================================================

    var nestedSortablesHandles = [].slice.call(document.querySelectorAll('.nested-sortable'));
    if (nestedSortablesHandles) {
        Array.from(nestedSortablesHandles).forEach(function (nestedSortHandle){
            sortable2 = new Sortable(nestedSortHandle, {
                // handle: '.handle',
                // group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onUpdate: function (evt) {
                var order = sortable2.toArray();
                $('#img-order-loading').css({ width: $('#images-list').outerWidth(), height: $('#images-list').outerHeight() + 5 }).fadeIn();
                    $.get("images_order.php?order="+order, function(data) {
                        $('#img-order-loading').fadeOut();
                    });
                }
            });
        });
    }

     //  ============================================================================
     //  === Planos Order
     //  ============================================================================

    var nestedSortablesHandles = [].slice.call(document.querySelectorAll('.nested-sortable-planos'));
    if (nestedSortablesHandles) {
        Array.from(nestedSortablesHandles).forEach(function (nestedSortHandle){
            sortable = new Sortable(nestedSortHandle, {
                // handle: '.handle',
                // group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onUpdate: function (evt) {
                var order = sortable.toArray();
                $('#planos-order-loading').css({ width: $('#planos-list').outerWidth(), height: $('#planos-list').outerHeight() + 5 }).fadeIn();
                    $.get("planos_order.php?order="+order, function(data) {
                        $('#planos-order-loading').fadeOut();
                    });
                }
            });
        });
    }

     //  ============================================================================
     //  === Images Delete
     //  ============================================================================

     $(document).on('click', '.del-img', function(e) {
         e.preventDefault();
         tb = $(this);
         img = tb.attr('href');
         Swal.fire({
             title: delRecord,
             text: delRecord2,
             icon: "warning",
             showCancelButton: true,
             confirmButtonClass: "btn btn-success w-xs me-2 mt-2",
             cancelButtonClass: "btn btn-danger w-xs mt-2",
             confirmButtonText: delRecordYes,
             cancelButtonText: delRecordNo,
             buttonsStyling: false,
             showCloseButton: true
         }).then(function (result) {
             if (result.value) {
                  $.get(img, { id: tb.attr('data-id') }, function(data) {
                      if(data == 'ok') {
                          $('#' + tb.closest('li').attr('id')).fadeOut('slow', function() { $(this).remove(); });
                      }
                  });
             }
         });
         return false;
     });

     //  ============================================================================
     //  === SEARCH LOCATION
     //  ============================================================================

      $('#gmap_search').bind('keypress keydown keyup', function (e) {
          if (e.keyCode == 13) {
              $('#search_on_map').click();
              e.preventDefault();
          }
      });

      $('.btn-copy-address').click(function(e) {
          e.preventDefault();
          copyToClipboard('direccion_gp_prop');
      });

      $('.btn-copy-latlong').click(function(e) {
          e.preventDefault();
          copyToClipboard('lat_long_gp_prop');
      });

      //  ============================================================================
      //  === Color picker
      //  ============================================================================

      $('.colorpicker').minicolors({
          theme: 'bootstrap'
      });

      //  ============================================================================
      //  === Required fields
      //  ============================================================================

      $('.required').parent("div").find("label").addClass("required");

    //  ============================================================================
    //  === Activar/Desactivar desde tablas
    //  ============================================================================

    $(document).on('click', '.update-status', function(e) {

        e.preventDefault();

        tb = $(this);

        tb.html('<div class="text-center mt-1"><i class="fa-solid fa-hourglass-end text-muted fa-flip" style="--fa-flip-x: 1; --fa-flip-y: 0;"></i></div>');

        $.get(tb.attr('href'), function(data) {
            tb.html(data);
            if(tb.attr('href').match(/v=0/)) {
                tb.attr('href', tb.attr('href').replace(/v=0/,"v=1"));
            } else {
                tb.attr('href', tb.attr('href').replace(/v=1/,"v=0"));
            }
        });

        return false;

    });

    //  ============================================================================
    //  === Bajada precios
    //  ============================================================================

    $(document).on('click', '.del-bajada', function(e) {
        e.preventDefault();

        tb = $(this);
        vid = tb.attr('href');

        Swal.fire({
            title: delRecord,
            text: delRecord2,
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success w-xs me-2 mt-2',
            cancelButtonClass: 'btn btn-danger w-xs mt-2',
            confirmButtonText: delRecordYes,
            cancelButtonText: delRecordNo,
            buttonsStyling: false,
            showCloseButton: true
        }).then(function (result) {
            if (result.value) {
                $.get(vid, function(data) {
                    if(data == 'ok') {
                        $('#' + tb.closest('tr').attr('id')).fadeOut('slow', function() { $(this).remove(); });
                    }
                });
            }
        });



        // if (confirm(delRecord)) {
        //     $.get(vid, function(data) {
        //         if(data == 'ok') {
        //             tb.parent().parent().fadeOut('slow', function() { $(this).remove(); });
        //         }
        //     });
        // }

        return false;

    });

    //  ============================================================================
    //  === 360º Add
    //  ============================================================================

    $('#add360').click(function (e){
        tb = $(this);
        e.preventDefault();
        if($('#txt360').val() != ''){
            $.get('360_add.php', { p: tb.attr('data-id'), vid: $('#txt360').val() }, function(data) {
                $('#tressesenta-list').append(data);
                $('#txt360').val('');
            });
        }
    });

    //  ============================================================================
    //  === Portlets
    //  ============================================================================

    $(".sortable .row .col-md-6").sortable({
        connectWith: ".sortable .row .col-md-6",
        handle: ".card-header",
        placeholder: "sortable-highlight",

        forcePlaceholderSize: true,
        tolerance: 'pointer',
        forceHelperSize: true,
        // revert: true,
        helper: 'original',
        opacity: 0.5,
        iframeFix: false,
        update: function() {
            var list =  $('#section1').sortable("toArray").join("|");
            var list2 =  $('#section2').sortable("toArray").join("|");
            $.cookie('section1', list);
            $.cookie('section2', list2);
        }
    });

    if ($.cookie('section1')) {
        var thePortles = $.cookie('section1').split("|");
        for (var i = 0; i < thePortles.length; i++) {
          thePortlet = '#' +thePortles[i];
          $(thePortlet).appendTo('#section1');
        }
    }

    if ($.cookie('section2')) {
        var thePortles2 = $.cookie('section2').split("|");
        for (var x = 0; x < thePortles2.length; x++) {
          thePortlet = '#' +thePortles2[x];
          $(thePortlet).appendTo('#section2');
        }
    }

    $('.sortable .row .col-md-6 .card').fadeIn();

    //  ============================================================================
    //  === Tooltips
    //  ============================================================================

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    //  ============================================================================
    //  === Popover
    //  ============================================================================

    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));

    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // $(document).on('mouseenter', '.popoverbtn', function() {
    //     $(this).popover('show');
    // });
    // $(document).on('mouseleave', '.popoverbtn', function() {
    //     $(this).popover('hide');
    // });

//  ============================================================================
//  === END jQuery Ready
//  ============================================================================

});

//  ============================================================================
//  === COPY TEXT
//  ============================================================================

function copyToClipboard(e) {
    var copyText = document.getElementById(e);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    Swal.fire({
        title: textCopy,
        text: copyText.value,
        icon: 'success',
        showCancelButton: false,
        confirmButtonClass: 'btn btn-success w-xs me-2 mt-2',
        cancelButtonClass: 'btn btn-danger w-xs mt-2',
        buttonsStyling: false,
        showCloseButton: true
    });
}

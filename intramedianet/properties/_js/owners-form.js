jQuery(document).ready(function($) {

    $('#keyholder_pro').change(function(e) {
        e.preventDefault();
        if ($(this).is(':checked') == true) {
            $('#keytxt').fadeIn('slow');
        } else{
            $('#keytxt').fadeOut('slow');
        }
    });

    $(".multi_files").pluploadQueue({
        runtimes : 'html5,flash,silverlight,html4',
        url : '/intramedianet/properties/ofiles_upload.php?id_fil=' + idOwner,
        max_file_size : '100mb',
        unique_names : false,
        multiple_queues: true,
        preinit : attachCallbacks2,
        dragdrop: true,
        filters : {
          mime_types: [
            {title : "Files", extensions : "rar,txt,zip,doc,pdf,csv,xls,rtf,sxw,odt,docx,xlsx,ppt,mov,eml"}
          ]
        },
        flash_swf_url : '../includes/assets/swf/Moxie.swf',
        silverlight_xap_url : '../includes/assets/swf/Moxie.xap'
    });


    function attachCallbacks2(uploader) {
        uploader.bind('FileUploaded', function(Up, File, Response) {
            if( (uploader.total.uploaded + 1) == uploader.files.length) {
                $.get("ofiles_list.php?id_fil=" + idOwner, function(data) {
                  if(data != '') {
                      $('#file-list').html(data);
                  }
                });
            }
        });
    }

    $(document).on('click', '.edit-name', function(e) {
        e.preventDefault();
        tb = $(this);
        $('#myModal2').modal('show').on('shown.bs.modal', function () {
            $.get('ofiles_names.php', { p: tb.attr('data-id') }, function(data) {
                $('#myModal2 .loadingfrm').css('background', '#fff').html(data);
            });
        }).on('hide.bs.modal', function () {
            $.post('ofiles_names.php', { p: tb.attr('data-id'), KT_Custom1: '1' , name_fil: $('#myModal2 #name_fil').val()  }, function(data) {
                $.get("ofiles_list.php?id_fil=" + idOwner, function(data) {
                    if(data != '') {
                       $('#file-list').html(data);
                    }
                });
                $('.loadingfrm').css('background', 'url(../includes/assets/img/loading_big.gif) no-repeat center center').html('');
            });
        });
    });

    $('.add-status').click( function(e) {
        $('#myModal5').modal('show').on('hide.bs.modal', myHandler999);
    });

    function myHandler999() {
        $.post('owners-status-form-ajax.php', {
            category_es_sts: $('#myModal5 #category_es_sts').val(),
            category_en_sts: $('#myModal5 #category_en_sts').val(),
            KT_Insert1: '1'
        }, function(data) {
          $('#myModal5 #category_es_sts').val('');
          $('#myModal5 #category_en_sts').val('');
          $.get('owners-get-status.php', { s: data, lang: appLang }, function(data2) {
              $('#status_pro').html(data2).select2("destroy").select2();
          });
        });
        $('#myModal5').off('hide', myHandler999);
    }

    $('.add-captado').click( function(e) {
        $('#myModal6').modal('show').on('hide.bs.modal', myHandler9996);
    });

    function myHandler9996() {
        $.post('owners-captado-form-ajax.php', {
            category_es_cap: $('#myModal6 #category_es_cap').val(),
            category_en_cap: $('#myModal6 #category_en_cap').val(),
            KT_Insert1: '1'
        }, function(data) {
            $('#myModal6 #category_es_cap').val('');
            $('#myModal6 #category_en_cap').val('');
            $.get('owners-get-captado.php', { s: data, lang: appLang }, function(data2) {
                $('#captado_por_pro').html(data2).select2("destroy").select2();
            });
        });
        $('#myModal6').off('hide', myHandler999);
    }

    $('.add-source').click( function(e) {
        $('#myModalSource').modal('show').on('hide.bs.modal', myHandlerSource);
    });

    function myHandlerSource() {
        $.post('owners-sources-form-ajax.php', {
            category_es_sts: $('#myModalSource #category_es_sts').val(),
            category_en_sts: $('#myModalSource #category_en_sts').val(),
            KT_Insert1: '1'
        }, function(data) {
          $('#myModalSource #category_es_sts').val('');
          $('#myModalSource #category_en_sts').val('');
          $.get('owners-get-sources.php', { s: data, lang: appLang }, function(data2) {
              $('#como_nos_conocio_pro').html(data2).select2("destroy").select2();
          });
        });
        $('#myModalSource').off('hide', myHandlerSource);
    }

    $('.addHist').click(function (e){

        e.preventDefault();

        var currentDate = new Date()
        var day = currentDate.getDate()
        var month = currentDate.getMonth() + 1
        var year = currentDate.getFullYear();
        var hour = currentDate.getHours();
        var minutes = currentDate.getMinutes();

        day = (day > 9)?day:'0'+day;
        month = (month > 9)?month:'0'+month;
        hour = (hour > 9)?hour:'0'+hour;
        minutes = (minutes > 9)?minutes:'0'+minutes;

        $('#historial_pro').val("[ " + day + "-" + month + "-" + year + " " + hour + ":" + minutes + " ] [ " + admiName + " ] → \n\n"+$('#historial_pro').val());

    });

    $('.addNot').click(function (e){

        e.preventDefault();

        var currentDate = new Date()
        var day = currentDate.getDate()
        var month = currentDate.getMonth() + 1
        var year = currentDate.getFullYear();
        var hour = currentDate.getHours();
        var minutes = currentDate.getMinutes();

        day = (day > 9)?day:'0'+day;
        month = (month > 9)?month:'0'+month;
        hour = (hour > 9)?hour:'0'+hour;
        minutes = (minutes > 9)?minutes:'0'+minutes;

        $('#notas_pro').val("[ " + day + "-" + month + "-" + year + " " + hour + ":" + minutes + " ] [ " + admiName + " ] → \n\n"+$('#notas_pro').val());

    });

    var oTable, asInitVals = [];

    $('#activado_prop_sel').change(function(e) {
        $('#activado_prop').val($(this).val()).trigger('keyup');
    });

    $("thead input").keyup( function () {
        oTable.fnFilter( this.value, oTable.oApi._fnVisibleToColumnIndex(
            oTable.fnSettings(), $("thead input").index(this) ) );
    });

    $("thead input").each( function (i) {
        asInitVals[i] = this.value;
    });

    $("thead input").blur( function (i) {
        if ( this.value == "" )
        {
            this.value = asInitVals[$("thead input").index(this)];
        }
    });

    $("thead .search-clear").click( function (i) {
        $("thead input").val('');
        $('select').val('');
        fnResetAllFilters()
    });

    function fnResetAllFilters() {
        var oSettings = oTable.fnSettings();
        for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
            oSettings.aoPreSearchCols[ iCol ].sSearch = '';
        }
        oTable.fnDraw();
    }

    oTable = $('#records-tables').dataTable({
        "sAjaxSource": "properties-owner-data.php?p="+idOwner,
        dom: "<'row'<'col-sm-12 table-responsive' tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>lB",
        "bSortCellsTop": true,
        buttons: [
            {
                extend: 'colvis',
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                className: 'btn btn-soft-primary btn-sm w-100',
                text: '<i class="fa-regular fa-table"></i>',
                align: "button-right"
            }
        ],
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                }
            }
            toggleScrollBarIcon();
            if ($('#activado_prop').val() != '') {
                $('#activado_prop_sel').val($('#activado_prop').val() );
            }
            $(document).delegate('*[data-toggle="lightbox"]', 'click', function(e) {
                e.preventDefault();
                $(this).ekkoLightbox();
            });
        },
        "aoColumns": [
            {
            "bSearchable": false,
            "bSortable": false,
            "sClass": "imgprop"
            },
            null,
            null,
            null,
            null,
            null,
            null,
            {
            "sName": "activado_prop",
            "bSearchable": true,
            "bSortable": true,
            "sClass": "ticks",
            "render": function ( data, type, row ) {
                if (data == non) {
                    return '<div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div>';
                } else{
                    return '<div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div>';
                }
            }
          },
            null,
            null,
            {
                "bSearchable": false,
                "bSortable": false,
                "sClass": "actions",
                "render": function ( data, type, row ) {
                        btns = '<div class="dropdown d-inline-block w-100">';
                            btns += '<button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                                btns += '<i class="fa-regular fa-ellipsis align-middle"></i>';
                            btns += '</button>';
                            btns += '<ul class="dropdown-menu dropdown-menu-end">';
                                btns += '<li><a href="properties-form.php?id_prop=' + data + '&amp;KT_back=1" target="_blank" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
                                btns += '<li><a href="/reporte/' + row[11] + '/" target="_blank" class="dropdown-item edit-item-btn"><i class="fa-regular fa-chart-pie align-bottom me-1"></i> ' + dtInfo + '</a></li>';
                                if (canDel == 1) {
                                    btns += '<li><hr class="dropdown-divider"></li>';
                                    btns += '<li><a href="properties-form.php?id_prop=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                                }
                            btns += '</ul>';
                        btns += '</div>';
                        return  btns;
                    }
            }
        ],
        "fnDrawCallback": function ( oSettings ) {
            $('#records-tables tbody tr').each( function () {
                var iPos = oTable.fnGetPosition( this );
                if (iPos!=null) {
                    var aData = oTable.fnGetData( iPos );
                    if (jQuery.inArray(aData[0], selected)!=-1)
                        $(this).addClass('row_selected');
                    if ( $(this).hasClass('row_selected') ) {
                         $(this).find('input').attr('checked', true);
                    }
                }
                $('.chklist').each( function () {
                    if(jQuery.inArray($(this).val(), selected)!=-1) {
                      $(this).attr('checked', true);
                    }
                  });
                $(this).find('input').click( function () {

                    var iPos = oTable.fnGetPosition( this.parentNode.parentNode );
                    var aData = oTable.fnGetData( iPos );
                    var iId = aData[0];

                    is_in_array = jQuery.inArray(iId, selected);
                    if (is_in_array==-1) {
                        selected[selected.length]=iId;
                    }
                    else {
                        selected = jQuery.grep(selected, function(value) {
                            return value != iId;
                        });
                    }
                    if ( $(this).is(':checked') ) {
                         $(this).parents('tr').addClass('row_selected');
                         $(this).attr('checked', true);

                    }
                    else {
                        $(this).parents('tr').removeClass('row_selected');
                        $(this).attr('checked', false);
                    }
                  $('.countusers').html(selected.length);
                  if (selected.length > 0) {
                    if (selected.length > 1) {
                      $('.countusers2').hide();
                      $('.countusers3').show();
                    } else{
                      $('.countusers3').hide();
                      $('.countusers2').show();
                    }
            $('.btnsendcont').fadeIn('slow');
                  } else {
            $('.btnsendcont').fadeOut('slow');
                  }
                });
            });
        }
    });

    $("#records-tables_length").appendTo("#col-1");
    $(".buttons-colvis").appendTo("#col-2");

    $('.btnsend').click(function(e) {
        e.preventDefault();
        if (!isValidEmailAddress($('#email_pro').val())) {
            alert(cliMailNo);
            return false;
        }
        if (!confirm(cliMailConf)) {
          return false;
        }
        var values = Array();
        var priceRegex = /([0-9]+)/;
        for (var i = 0; i < selected.length; i++) {
            // var match = selected[i].match(priceRegex);
            // values.push(match[1]);
            values.push(selected[i]);
        }
        values = values.join(',');
        $.ajax({
          type: "GET",
          url: "owners-send.php?ids="+values+'&email='+$('#email_pro').val()+'&comment='+$('#comment').val().replace( /\r?\n/g, "<br>" )+'&lang=' + appLang + '&usr=' + idOwner,
            cache: false
        }).done(function( data ) {
              if(data == 'ok') {
                alert(mensaSend);
              }
        });
    });

    $(document).on('click', '.add-cita', function(e) {
        e.preventDefault();
        tb = $(this);
        $('.add-cita').attr('name','KT_Insert1');
        $('#myModal').modal('show');
    });

    $(document).on('click', '#btn-close-save', function(e) {
        e.preventDefault();
        tb = $(this);
        // if ($("#form10").valid()) {
            var formVals = $("#form10").serialize();
            $.get("/intramedianet/calendar/calendario-form.php?"+formVals+"&"+$('.add-cita').attr('name')+"=ok", function(data) {
                alert(calAddOk);
                $('#myModal').modal('hide');
            });
        // }
    });

    $(document).on('click', '#btn-close', function(e) {
      e.preventDefault();
      tb = $(this);
      clearCitaForm();
      $('#myModal').modal('hide');
    });

    function clearCitaForm() {
        $('#form1 input[type=text], #form1 textarea').val('');
        $('#form1 #categoria_ct, #form1 #users_ct, #form1 #property_ct').val('').trigger('liszt:updated');
    }

    $('.addHistCit').click(function (e){
        e.preventDefault();
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1;
        var year = currentDate.getFullYear();
        var hour = currentDate.getHours();
        var minutes = currentDate.getMinutes();
        day = (day > 9)?day:'0'+day;
        month = (month > 9)?month:'0'+month;
        hour = (hour > 9)?hour:'0'+hour;
        minutes = (minutes > 9)?minutes:'0'+minutes;
        $('#notas_ct').val("[ " + day + "-" + month + "-" + year + " " + hour + ":" + minutes + " ] [ " + admiName + " ] → \n\n"+$('#notas_ct').val());
    });

    $('#inicio_ct, #final_ct').flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });

    // jQuery('.datetimepicker').datetimepicker({
    //    lang: appLang,
    //    format:'d-m-Y H:i',
    //    step: 15,
    // });

});

function isValidEmailAddress(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

$('.btnsendemail').click(function(e) {
  e.preventDefault();
  if (!isValidEmailAddress($('#email_pro').val())) {
      alert(cliMailNo);
      return false;
  }
  if ($('#subjectSM').val() == '') {
      alert(strFieldSubject);
      return false;
  }
  if ($('#messagemail').val() == '') {
      alert(strFieldMessage);
      return false;
  }
  if (!confirm(cliMailConf)) {
    return false;
  }
  $.ajax({
    type: "GET",
    url: "owners-send-email.php?subject="+$('#subjectSM').val()+'&cco=' + $('#ccoEml').val() + '&message=' + encodeURIComponent($('#messagemail').val()) + '&email='+$('#email_pro').val()+'&tipo=4&lang=' + $('#idioma_pro').val() + '&usr=' + idOwner,
      cache: false
  }).done(function( data ) {
        if(data == 'ok') {
          alert(mensaSend);
          $('#subjectSM').val('');
          $('#messagemail').redactor('source.setCode', '');
          $('#form1 .loadingMail').remove();
        }
  });
});

$(document).on("click","#proptabs a", function(e){ //user click on remove text
    window.scrollTo({ top: 0, behavior: 'smooth' });
    if ($(this).attr('href') == '#tabcruce') {
        $('#interesados-tab').click();
    }
});

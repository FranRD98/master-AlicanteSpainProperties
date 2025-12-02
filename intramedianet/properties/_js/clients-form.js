$(function () {

    $(".multi_files").pluploadQueue({
        runtimes: 'html5,flash,silverlight,html4',
        url: '/intramedianet/properties/cfiles_upload.php?id_cli=' + idClient,
        max_file_size: '100mb',
        unique_names: false,
        multiple_queues: true,
        preinit: attachCallbacks2,
        dragdrop: true,
        filters: {
            mime_types: [{
                title: "Files",
                extensions: "rar,txt,zip,doc,pdf,csv,xls,rtf,sxw,odt,docx,xlsx,ppt,mov,eml"
            }]
        },
        flash_swf_url: '../includes/assets/swf/Moxie.swf',
        silverlight_xap_url: '../includes/assets/swf/Moxie.xap'
    });


    function attachCallbacks2(uploader) {
        uploader.bind('FileUploaded', function (Up, File, Response) {
            if ((uploader.total.uploaded + 1) == uploader.files.length) {
                $.get("cfiles_list.php?id_cli=" + idClient, function (data) {
                    if (data != '') {
                        $('#file-list').html(data);
                    }
                });
            }
        });
    }

    $(document).on('click', '.edit-name', function (e) {
        e.preventDefault();
        tb = $(this);
        $('#myModal2').modal('show').on('shown.bs.modal', function () {
            $.get('cfiles_names.php', {
                p: tb.attr('data-id')
            }, function (data) {
                $('#myModal2 .loadingfrm').css('background', '#fff').html(data);
            });
        }).on('hide.bs.modal', function () {
            $.post('cfiles_names.php', {
                p: tb.attr('data-id'),
                KT_Custom1: '1',
                name_fil: $('#myModal2 #name_fil').val()
            }, function (data) {
                $.get("cfiles_list.php?id_cli=" + idClient, function (data) {
                    if (data != '') {
                        $('#file-list2').html(data);
                    }
                });
                $('.loadingfrm').css('background', 'url(../includes/assets/img/loading_big.gif) no-repeat center center').html('');
            });
        });
    });

    $('.add-status').click(function (e) {
        $('#myModal5').modal('show');
    });

    $('#myModal5 a.btn-success').click(function (e) {
        e.preventDefault();
        myHandler999();
    });

    function myHandler999() {
        if ($('#myModal5 #category_es_sts').val() =='' || $('#myModal5 #category_en_sts').val() == '') {
            return false;
        }
        $.post('clients-status-form-ajax.php', {
            category_es_sts: $('#myModal5 #category_es_sts').val(),
            category_en_sts: $('#myModal5 #category_en_sts').val(),
            KT_Insert1: '1'
        }, function (data) {
            $('#myModal5 #category_es_sts').val('');
            $('#myModal5 #category_en_sts').val('');
            $.get('clients-get-status.php', {
                s: data,
                lang: appLang
            }, function (data2) {
                $('#status_cli').html(data2).select2("destroy").select2();
            });
        });
        $('#myModal5').off('hide', myHandler999);
    }

    $('.add-captado').click(function (e) {
        $('#myModal6').modal('show');
    });

    $('#myModal6 a.btn-success').click(function (e) {
        e.preventDefault();
        myHandler9996();
    });


    function myHandler9996() {
        if ($('#myModal6 #category_es_cap').val() =='' || $('#myModal6 #category_en_cap').val() == '') {
            return false;
        }
        $.post('clients-captado-form-ajax.php', {
            category_es_cap: $('#myModal6 #category_es_cap').val(),
            category_en_cap: $('#myModal6 #category_en_cap').val(),
            KT_Insert1: '1'
        }, function (data) {
            $('#myModal6 #category_es_cap').val('');
            $('#myModal6 #category_en_cap').val('');
            $.get('clients-get-captado.php', {
                s: data,
                lang: appLang
            }, function (data2) {
                $('#captado_por2_cli').html(data2).select2("destroy").select2();
            });
        });
        $('#myModal6').off('hide', myHandler999);
    }

    $('.add-source').click(function (e) {
        $('#myModalSource').modal('show');
    });

    $('#myModalSource a.btn-success').click(function (e) {
        e.preventDefault();
        myHandlerSource();
    });

    function myHandlerSource() {
        if ($('#myModalSource #category_es_sts').val() =='' || $('#myModalSource #category_en_sts').val() == '') {
            return false;
        }
        $.post('clients-sources-form-ajax.php', {
            category_es_sts: $('#myModalSource #category_es_sts').val(),
            category_en_sts: $('#myModalSource #category_en_sts').val(),
            KT_Insert1: '1'
        }, function (data) {
            $('#myModalSource #category_es_sts').val('');
            $('#myModalSource #category_en_sts').val('');
            $.get('clients-get-sources.php', {
                s: data,
                lang: appLang
            }, function (data2) {
                $('#como_nos_conocio_cli').html(data2).select2("destroy").select2();
            });
        });
        $('#myModalSource').off('hide', myHandlerSource);
    }

    // jQuery('.datetimepicker').datetimepicker({
    //    lang: appLang,
    //    format:'d-m-Y H:i',
    //    step: 15,
    // });

    function clearCitaForm() {
        $('#form1 input[type=text], #form1 textarea').val('');
        $('#form1 #categoria_ct, #form1 #users_ct, #form1 #property_ct').val('').trigger('liszt:updated');
    }

    $(document).on('click', '.add-cita', function (e) {
        e.preventDefault();
        tb = $(this);
        $('.add-cita').attr('name', 'KT_Insert1');
        $('#myModal').modal('show');
    });

    $(document).on('click', '#btn-close-save', function (e) {
        e.preventDefault();
        tb = $(this);
        var formVals = $("#form10").serialize();
        $.get("/intramedianet/calendar/calendario-form.php?" + formVals + "&" + $('.add-cita').attr('name') + "=ok", function (data) {
            alert(calAddOk);
            $('#myModal').modal('hide');
        });
    });

    $(document).on('click', '#btn-close', function (e) {
        e.preventDefault();
        tb = $(this);
        clearCitaForm();
        $('#myModal').modal('hide');
    });

    $('.addHistCit').click(function (e) {
        e.preventDefault();
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1;
        var year = currentDate.getFullYear();
        var hour = currentDate.getHours();
        var minutes = currentDate.getMinutes();
        day = (day > 9) ? day : '0' + day;
        month = (month > 9) ? month : '0' + month;
        hour = (hour > 9) ? hour : '0' + hour;
        minutes = (minutes > 9) ? minutes : '0' + minutes;
        $('#notas_ct').val("[ " + day + "-" + month + "-" + year + " " + hour + ":" + minutes + " ] [ " + admiName + " ] → \n\n" + $('#notas_ct').val());
    });

    $('.addHist').click(function (e) {
        e.preventDefault();
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1;
        var year = currentDate.getFullYear();
        var hour = currentDate.getHours();
        var minutes = currentDate.getMinutes();
        day = (day > 9) ? day : '0' + day;
        month = (month > 9) ? month : '0' + month;
        hour = (hour > 9) ? hour : '0' + hour;
        minutes = (minutes > 9) ? minutes : '0' + minutes;
        $('#historial_cli').val("[ " + day + "-" + month + "-" + year + " " + hour + ":" + minutes + " ] [ " + admiName + " ] → \n\n" + $('#historial_cli').val());
    });

    $('.addNot').click(function (e) {
        e.preventDefault();
        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1;
        var year = currentDate.getFullYear();
        var hour = currentDate.getHours();
        var minutes = currentDate.getMinutes();
        day = (day > 9) ? day : '0' + day;
        month = (month > 9) ? month : '0' + month;
        hour = (hour > 9) ? hour : '0' + hour;
        minutes = (minutes > 9) ? minutes : '0' + minutes;
        $('#notas_cli').val("[ " + day + "-" + month + "-" + year + " " + hour + ":" + minutes + " ] [ " + admiName + " ] → \n\n" + $('#notas_cli').val());
    });



    var oTable, asInitVals = [];

    $('#activado_prop_sel').change(function(e) {
        $('#activado_prop').val($(this).val()).trigger('keyup');
    });

    $("#records-tables thead input").keyup( function () {
        oTable.fnFilter( this.value, oTable.oApi._fnVisibleToColumnIndex(
        oTable.fnSettings(), $("#records-tables thead input").index(this) ) );
    });

    $("#records-tables thead input").each( function (i) {
        asInitVals[i] = this.value;
    });

    $("#records-tables thead input").blur( function (i) {
        if ( this.value == "" ) {
            this.value = asInitVals[$("thead input").index(this)];
        }
    });

    $("#records-tables thead .search-clear").click( function (i) {
        $("#records-tables thead input").val('');
        $('#records-tables select').val('');
        fnResetAllFilters()
    });

    function fnResetAllFilters() {
        var oSettings = oTable.fnSettings();
        for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
            oSettings.aoPreSearchCols[ iCol ].sSearch = '';
        }
        oTable.fnDraw();
    }

    var oTable = $('#records-tables').dataTable({
        "sAjaxSource": "properties-client-data-cli.php?"+ $('#search-fields :input').serialize()+"&id_cli="+idClient + "&email="+$('#email_cli').val(),
        "bSortCellsTop": true,
        dom: "<'row'<'col-sm-12 table-responsive' tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>lB",
        buttons: [
            {
                extend: 'colvis',
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                className: 'btn btn-soft-primary btn-sm w-100',
                text: '<i class="fa-regular fa-table"></i>',
                align: "button-right"
            }
        ],
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("#records-tables thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
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
              "sName": "offert_prop",
              "bSearchable": false,
              "bSortable": false,
              "render": function ( data, type, row ) {
                $ret = '<div class="form-check form-switch form-switch-sm text-center pt-2 activate_nws" dir="ltr"><input type="checkbox" name="activate_nws" id="activate_nws" value="' + data + '" class="form-check-input"></div>';
                if (row[16] == 1) {
                    $ret += '<div class="text-center text-primary mt-2"><i class="fa-solid fs-22 fa-envelope text-primary"></i></div>';
                }
                  return $ret;
              }
            },
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
            null,
            null,
            null,
            null,
            {
                "bSearchable": false,
                "bSortable": false,
                "sClass": "actions text-center",
                "render": function ( data, type, row ) {
                        // btns = '<a href="javascript:;" class="btn btn-danger btn-sm hiderow" data-ref="'+row[2]+'">' + cliOcultar + '</a> <br>';
                        btns = '<a href="properties-form.php?id_prop=' + row[0] + '" target="_blank" class="btn btn-success btn-sm w-100 mb-1"><i class="fa fa-pencil"></i></a><br>';
                        // btns += '<a href="_update-client-props.php?act=add&sec=si&id_prop=' + row[0] + '&id_cli=' + idClient + '" target="_blank" class="btn btn-success btn-sm btn-clnt"><i class="fa-regular fa-fw fa-check" aria-hidden="true"></i></a> ';
                        // btns += '<a href="_update-client-props.php?act=add&sec=no&id_prop=' + row[0] + '&id_cli=' + idClient + '" target="_blank" class="btn btn-danger btn-sm btn-clnt"><i class="fa-regular fa-fw fa-times" aria-hidden="true"></i></a> ';
                        // if (row[12] == 1) {
                        //     btns += '<div class="btn btn-link btn-sm"><i class="fa-solid fs-22 fa-envelope"></i></div>';
                        // }

                        // btns = '<div class="dropdown d-inline-block w-100">';
                        //     btns += '<button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                        //         btns += '<i class="fa-regular fa-ellipsis align-middle"></i>';
                        //     btns += '</button>';
                        //     btns += '<ul class="dropdown-menu dropdown-menu-end">';
                        //         btns += '<li><a href="properties-form.php?id_prop=' + data + '&amp;KT_back=1" target="_blank" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
                        //         if (canDel == 1) {
                        //             btns += '<li><hr class="dropdown-divider"></li>';
                        //             btns += '<li><a href="properties-form.php?id_prop=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                        //         }
                        //     btns += '</ul>';
                        // btns += '</div>';
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
                        // $('.btnsendcont').fadeIn('slow');
                  } else {
                        // $('.btnsendcont').fadeOut('slow');
                  }
                });
            });
        }
    });

var oTable2, asInitVals2 = [];

$('#activado_prop_sel').change(function(e) {
    $('#activado_prop').val($(this).val()).trigger('keyup');
});

$("#records-tables2 thead input").keyup( function () {
    oTable2.fnFilter( this.value, oTable2.oApi._fnVisibleToColumnIndex(
    oTable2.fnSettings(), $("#records-tables2 thead input").index(this) ) );
});

$("#records-tables2 thead input").each( function (i) {
    asInitVals2[i] = this.value;
});

$("#records-tables2 thead input").blur( function (i) {
    if ( this.value == "" ) {
        this.value = asInitVals2[$("thead input").index(this)];
    }
});

$("#records-tables2 thead .search-clear").click( function (i) {
    $("#records-tables2 thead input").val('');
    $('#records-tables2 select').val('');
    fnResetAllFilters()
});

function fnResetAllFilters() {
    var oSettings = oTable2.fnSettings();
    for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
        oSettings.aoPreSearchCols[ iCol ].sSearch = '';
    }
    oTable2.fnDraw();
}

var oTable2 = $('#records-tables2').dataTable({
    "sAjaxSource": "properties-client-data-cli-intno.php?"+ $('#search-fields :input').serialize()+"&id_cli="+idClient + "&email="+$('#email_cli').val(),
    "bSortCellsTop": true,
    dom: "<'row'<'col-sm-12 table-responsive' tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>lB",
    buttons: [
        {
            extend: 'colvis',
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
            className: 'btn btn-soft-primary btn-sm w-100',
            text: '<i class="fa-regular fa-table"></i>',
            align: "button-right"
        }
    ],
    "fnInitComplete": function() {
        var oSettings = $('#records-tables2').dataTable().fnSettings();
        for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
            if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                $("#records-tables2 thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
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
        null,
        null,
        null,
        null,
        {
            "bSearchable": false,
            "bSortable": false,
            "sClass": "actions text-center",
            "render": function ( data, type, row ) {
                    // btns = '<a href="javascript:;" class="btn btn-danger btn-sm hiderow" data-ref="'+row[2]+'">' + cliOcultar + '</a> <br>';
                    btns = '<a href="properties-form.php?id_prop=' + row[14] + '" target="_blank" class="btn btn-success btn-sm w-100 mb-1"><i class="fa fa-pencil"></i></a>';
                    // btns += '<a href="_update-client-props.php?act=add&sec=si&id_prop=' + row[0] + '&id_cli=' + idClient + '" target="_blank" class="btn btn-success btn-sm btn-clnt"><i class="fa-regular fa-fw fa-check" aria-hidden="true"></i></a> ';
                    // btns += '<a href="_update-client-props.php?act=add&sec=no&id_prop=' + row[0] + '&id_cli=' + idClient + '" target="_blank" class="btn btn-danger btn-sm btn-clnt"><i class="fa-regular fa-fw fa-times" aria-hidden="true"></i></a> ';
                    // if (row[12] == 1) {
                    //     btns += '<div class="btn btn-link btn-sm"><i class="fa-solid fs-22 fa-envelope"></i></div>';
                    // }

                    // btns = '<div class="dropdown d-inline-block w-100">';
                    //     btns += '<button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                    //         btns += '<i class="fa-regular fa-ellipsis align-middle"></i>';
                    //     btns += '</button>';
                    //     btns += '<ul class="dropdown-menu dropdown-menu-end">';
                    //         btns += '<li><a href="properties-form.php?id_prop=' + data + '&amp;KT_back=1" target="_blank" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
                    //         if (canDel == 1) {
                    //             btns += '<li><hr class="dropdown-divider"></li>';
                    //             btns += '<li><a href="properties-form.php?id_prop=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                    //         }
                    //     btns += '</ul>';
                    // btns += '</div>';
                    return  btns;
                }
        }
    ],
    "fnDrawCallback": function ( oSettings ) {
        $('#records-tables2 tbody tr').each( function () {
            var iPos = oTable2.fnGetPosition( this );
            if (iPos!=null) {
                var aData = oTable2.fnGetData( iPos );
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

                var iPos = oTable2.fnGetPosition( this.parentNode.parentNode );
                var aData = oTable2.fnGetData( iPos );
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
                    // $('.btnsendcont').fadeIn('slow');
              } else {
                    // $('.btnsendcont').fadeOut('slow');
              }
            });
        });
    }
});

    $(document).on('click', '#records-tables-all', function (e) {
        e.preventDefault();
        $('#records-tables tbody tr').find(':checkbox').each(function(index, el) {
            if ($(this).prop('checked') != true) {
                $(this).prop('checked', false).click();
            }
        });
        return false;
    });

    $(document).on('click', '#records-tables-none', function (e) {
        e.preventDefault();
        $('#records-tables tbody tr').find(':checkbox').each(function(index, el) {
            if ($(this).prop('checked') != false) {
                $(this).prop('checked', true).click();
            }
        });
        return false;
    });

    $("#resultados #records-tables_length").appendTo("#col-1");
    $("#resultados .buttons-colvis").appendTo("#col-2");

    $("#descartados #records-tables2_length").appendTo("#descartados  #col-1");
    $("#descartados .buttons-colvis").appendTo("#descartados  #col-2");

    $('.btnsend').click(function (e) {
        e.preventDefault();

        if (!isValidEmailAddress($('#email_cli').val())) {
            alert(cliMailNo);
            return false;
        }
        if (!confirm(cliMailConf)) {
            return false;
        }
        sendLang = 'en';
        if ($('#idioma_cli').val() != '') {
            sendLang = $('#idioma_cli').val();
        }
        var values = Array();
        var priceRegex = /([0-9]+)/;
        for (var i = 0; i < selected.length; i++) {
            // var match = selected[i].match(priceRegex);
            // values.push(match[1]);
            values.push(selected[i]);
        }
        $(this).append('<div class="loadingMail">');
        values = values.join(',');
        $.ajax({
            type: "GET",
            url: "clients-send2.php?ids=" + $('.idsselcrit').val() + '&email=' + $('#email_cli').val() + '&cco=' + $('#ccoSrch').val() + '&subject=' + $('#subjcrt').val() + '&comment=' + encodeURIComponent($('#comment').val().replace(/\r?\n/g, "<br>")) + '&tipo=1&lang=' + sendLang + '&usr=' + idClient + '&' + $('#btnsendcont').find('select, textarea, input').serialize(),

            cache: false
        }).done(function (data) {
            if (data == 'ok') {
                alert(mensaSend);
                $('#form1 .loadingMail').remove();
            }
        });
    });

    $("#b_loc2_cli").change(function (e) {
        var val = $(this).val();
        $.get("/modules/search/towns.php?lopr=" + val + "&lang=" + appLang, function (data) {
            if (data != '') {
                $('#b_loc3_cli').html(data).change();
            }
        });
    });

    $("#b_loc3_cli").change(function (e) {
        var val = $(this).val();
        $.get("/modules/search/areas.php?loct=" + val + "&lang=" + appLang, function (data) {
            if (data != '') {
                $('#b_loc4_cli').html(data).change();
            }
        });
    });

    $("#b_costa_cli").change(function (e) {
        var val = $(this).val();
        $.get("/modules/search/coasts.php?coast=" + val + "&lang=" + appLang, function (data) {
            if (data != '') {
                $('#b_loc3_cli').html(data).change();
            }
        });
    });

    $(".select2").change(function (e) {
        getProps();
    });
    $("#b_dist_beach_val_cli, #b_dist_amenit_val_cli, #b_dist_airport_val_cli, #b_dist_golf_val_cli").change(function (e) {
        getProps();
    });

    $('#b_precio_desde_cli, #b_precio_hasta_cli, #b_dist_beach_from_cli, #b_dist_beach_to_cli, #b_dist_amenit_from_cli, #b_dist_amenit_to_cli, #b_dist_airport_from_cli, #b_dist_airport_to_cli, #b_dist_golf_from_cli, #b_dist_golf_to_cli, #b_m2_desde_cli, #b_m2_hasta_cli, #b_m2p_desde_cli, #b_m2p_hasta_cli').keyup(function (e) {
        getProps();
    });
    $('#b_precio_desde_cli, #b_precio_hasta_cli').keyup(function (e) {
        getProps();
    });

    $.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw ){
        if ( sNewSource !== undefined && sNewSource !== null ) {
            oSettings.sAjaxSource = sNewSource;
        }
        if ( oSettings.oFeatures.bServerSide ) {
            this.fnDraw();
            return;
        }
        this.oApi._fnProcessingDisplay( oSettings, true );
        var that = this;
        var iStart = oSettings._iDisplayStart;
        var aData = [];
        this.oApi._fnServerParams( oSettings, aData );
        oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
            that.oApi._fnClearTable( oSettings );
            var aData =  (oSettings.sAjaxDataProp !== "") ?
                that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
            for ( var i=0 ; i<aData.length ; i++ ) {
                that.oApi._fnAddData( oSettings, aData[i] );
            }
            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            that.fnDraw();
            $('.popoverbtn').hover(function() {
              $(this).popover('show');
            }, function() {
              $(this).popover('hide');
            });
            if ( bStandingRedraw === true ) {
                oSettings._iDisplayStart = iStart;
                that.oApi._fnCalculateEnd( oSettings );
                that.fnDraw( false );
            }
            that.oApi._fnProcessingDisplay( oSettings, false );
            if ( typeof fnCallback == 'function' && fnCallback !== null ) {
                fnCallback( oSettings );
            }
        }, oSettings );
    };



    $(document).on('click', '.hiderow', function (e) {
        e.preventDefault();
        btn = $(this);
        var selected = $("#b_ocultos_cli option:selected").map(function () {
            return this.value
        }).get();
        selected.push(btn.data('ref'));
        $('#b_ocultos_cli').val(selected);
        $("#b_ocultos_cli").select2("destroy").select2();
        $('#b_precio_desde_cli').keyup();
        alert(cliAviso);
    });

    $('.records-tables-simple').dataTable({
        dom: "<'row'<'col-sm-12 table-responsive'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayStart": 0,
        "iDisplayLength": 20,
        "bProcessing": false,
        "bStateSave": false,
        "bServerSide": false,
        "columnDefs": [{
            "type": "date-euro",
            targets: 2
        }]
    });

    $('.records-tables-simple2').dataTable({
        dom: "<'row'<'col-sm-12 table-responsive' ftr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayStart": 0,
        "iDisplayLength": 20,
        "bProcessing": false,
        "bStateSave": false,
        "bServerSide": false,
        language: {
            searchPlaceholder: strSearch
        },
        "columnDefs": [{
            "type": "date-euro",
            targets: 4
        }]
    });

    $('.records-tables-simple3').dataTable({
        dom: "<'row'<'col-sm-12 table-responsive'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayStart": 0,
        "iDisplayLength": 20,
        "bProcessing": false,
        "bStateSave": false,
        "bServerSide": false,
        "columnDefs": [{
                "type": "date-euro",
                targets: 2
            },
            {
                "type": "date-euro",
                targets: 3
            }
        ]
    });

    $('.records-tables-simple4').dataTable({
        dom: "<'row'<'col-sm-12 table-responsive'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayStart": 0,
        "iDisplayLength": 20,
        "bProcessing": false,
        "bStateSave": false,
        "bServerSide": false,
        "columnDefs": [{
            "type": "date-euro",
            targets: 3
        }]
    });

    $(window).change('.search-inputs-reg select', function(e) {
        var current = $(e.target);
        $(current).prev().val($(current).val()).trigger('keyup');
    });

    var oTableREG, asInitValsREG = [];

    $("thead input").keyup( function () {
        oTableREG.fnFilter( this.value, oTableREG.oApi._fnVisibleToColumnIndex(
            oTableREG.fnSettings(), $("thead input").index(this) ) );
    });

    $("thead input").each( function (i) {
        asInitValsREG[i] = this.value;
    });

    $("thead input").blur( function (i) {
        if ( this.value == "" )
        {
            this.value = asInitValsREG[$("thead input").index(this)];
        }
    });

    $("thead .search-clear").click( function (i) {
        $("thead input").val('');
        fnResetAllFilters()
    });

    function fnResetAllFilters() {
        var oSettingsREG = oTableREG.fnSettings();
        for(iCol = 0; iCol < oSettingsREG.aoPreSearchCols.length; iCol++) {
            oSettingsREG.aoPreSearchCols[ iCol ].sSearch = '';
        }
        oTableREG.fnDraw();
    }

    oTableREG = $('#records-tables-rates').dataTable({
        "sAjaxSource": "clients-rates-data.php?id_cli=" + idClient,
        "bSortCellsTop": true,
        "fnInitComplete": function() {
            var oSettingsREG = $('#records-tables-rates').dataTable().fnSettings();
            for ( var i=0 ; i<oSettingsREG.aoPreSearchCols.length ; i++ ){
                if(oSettingsREG.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettingsREG.aoPreSearchCols[i].sSearch;
                }
            }
            toggleScrollBarIcon();
        },
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                    btns  = '<a href="/intramedianet/properties/clients-form.php?id_cli=' + data + '&amp;KT_back=1" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a> ';
                    return  btns;
                },
                "targets": 9,
                "orderable": false,
                "className": "actions"
            }
        ]
    });

    $("#records-tables-rates_length").appendTo("th#actions");

});

var selected = [];

function isValidEmailAddress(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function getProps() {
    oTable = $('#records-tables').dataTable();
    oTable.fnReloadAjax("properties-client-data-cli.php?"+ $('#search-fields :input').serialize()+"&id_cli="+idClient + "&email="+$('#email_cli').val());
    oTable2 = $('#records-tables2').dataTable();
    oTable2.fnReloadAjax("properties-client-data-cli-intno.php?"+ $('#search-fields :input').serialize()+"&id_cli="+idClient + "&email="+$('#email_cli').val());
    getNews();
}

function getNews() {
    $.get("_count_news.php?"+ $('#search-fields :input').serialize()+"&id_cli="+idClient, function(data) {
          $('.countlistnews').html(data);
          $('.countlistnews2').html(data);
    });
    $.get("_count_news_int.php?"+ $('#search-fields :input').serialize()+"&id_cli="+idClient, function(data) {
          $('.countlistint').html('<i class="fa-solid fa-thumbs-up"></i> ' + data);
          $('.countlistint2').html(data);
    });
    $.get("_count_news_intno.php?"+ $('#search-fields :input').serialize()+"&id_cli="+idClient, function(data) {
          $('.countlistintno').html('<i class="fa-solid fa-thumbs-down"></i> ' + data);
          $('.countlistintno2').html(data);
    });
    $.get("_count_news_excluded.php?"+ $('#search-fields :input').serialize()+"&id_cli="+idClient, function(data) {
          $('.countlistexcluded').html(data);
          $('.countlistexcluded2').html(data);
    });
}

getNews();

$(document).on('click', '.btn-clnt', function (e) {
    e.preventDefault();
    $.get($(this).attr('href'), function (data) {
        getProps();
    });
});

$(document).on('click', '.unprocessed-links', function (e) {
    e.preventDefault();

    $.get($(this).attr('href'), function (data) {
        $('#unprocessed').html(data);
    }).done(function () {
        for (var i = selected.length - 1; i >= 0; i--) {
            $('#name' + selected[i]).prop('checked', true);
        }
        if (selected != '') {
            // $('.btnsendcont').fadeIn('slow');
        } else {
            // $('.btnsendcont').fadeOut('slow');
        }
    });

});

$(document).on('click', '.unprocessed-links-int', function (e) {
    e.preventDefault();

    $.get($(this).attr('href'), function (data) {
        $('#interesantes').html(data);
    }).done(function () {
        for (var i = selected.length - 1; i >= 0; i--) {
            $('#name' + selected[i]).prop('checked', true);
        }
        if (selected != '') {
            // $('.btnsendcont').fadeIn('slow');
        } else {
            // $('.btnsendcont').fadeOut('slow');
        }
    });

});

$(document).on('click', '.unprocessed-links-intno', function (e) {
    e.preventDefault();

    $.get($(this).attr('href'), function (data) {
        $('#descartados').html(data);
    }).done(function () {
        for (var i = selected.length - 1; i >= 0; i--) {
            $('#name' + selected[i]).prop('checked', true);
        }
        if (selected != '') {
            // $('.btnsendcont').fadeIn('slow');
        } else {
            // $('.btnsendcont').fadeOut('slow');
        }
    });

});

$(document).on('change', '#unprocessed-links-int', function (e) {
    e.preventDefault();

    $.get($(this).val(), function (data) {
        $('#interesantes').html(data);
    }).done(function () {
        for (var i = selected.length - 1; i >= 0; i--) {
            $('#name' + selected[i]).prop('checked', true);
        }
        if (selected != '') {
            // $('.btnsendcont').fadeIn('slow');
        } else {
            // $('.btnsendcont').fadeOut('slow');
        }
    });

});

$(document).on('change', '#unprocessed-links-intno', function (e) {
    e.preventDefault();

    $.get($(this).val(), function (data) {
        $('#descartados').html(data);
    }).done(function () {
        for (var i = selected.length - 1; i >= 0; i--) {
            $('#name' + selected[i]).prop('checked', true);
        }
        if (selected != '') {
            // $('.btnsendcont').fadeIn('slow');
        } else {
            // $('.btnsendcont').fadeOut('slow');
        }
    });

});

$(document).on('click', '#records-tables-all', function (e) {
    e.preventDefault();
    $('#resultados').find(':checkbox').each(function (index, el) {
        if ($(this).prop('checked') != true) {
            $(this).prop('checked', false).click();
        }
    });
    return false;
});

$(document).on('click', '#records-tables-none', function (e) {
    e.preventDefault();
    $('#resultados').find(':checkbox').each(function (index, el) {
        if ($(this).prop('checked') != false) {
            $(this).prop('checked', true).click();
        }
    });
    return false;
});

$(document).on('click', '#interesantes-all', function (e) {
    e.preventDefault();
    $('#interesantes').find(':checkbox').each(function (index, el) {
        if ($(this).prop('checked') != true) {
            $(this).prop('checked', false).click();
        }
    });
    return false;
});

$(document).on('click', '#interesantes-none', function (e) {
    e.preventDefault();
    $('#interesantes').find(':checkbox').each(function (index, el) {
        if ($(this).prop('checked') != false) {
            $(this).prop('checked', true).click();
        }
    });
    return false;
});

$(document).on('click', '#descartados-all', function (e) {
    e.preventDefault();
    $('#descartados').find(':checkbox').each(function (index, el) {
        if ($(this).prop('checked') != true) {
            $(this).prop('checked', false).click();
        }
    });
    return false;
});

$(document).on('click', '#descartados-none', function (e) {
    e.preventDefault();
    $('#descartados').find(':checkbox').each(function (index, el) {
        if ($(this).prop('checked') != false) {
            $(this).prop('checked', true).click();
        }
    });
    return false;
});




$(document).on('change', '.chklist', function (e) {
    e.preventDefault();

    $('.chklist').each(function () {
        if ($(this).prop('checked') == true) {
            var found = jQuery.inArray($(this).val(), selected);
            if (found >= 0) {} else {
                selected.push($(this).val());
            }
        } else {
            var found = jQuery.inArray($(this).val(), selected);
            if (found >= 0) {
                selected.splice(found, 1);
            } else {}
        }
    });

    if (selected != '') {
        // $('.btnsendcont').fadeIn('slow');
    } else {
        // $('.btnsendcont').fadeOut('slow');
    }

    $('.countusers').html(selected.length);

});

$('.chklist').first().change();

$(document).delegate('*[data-toggle="lightbox"]', 'click', function (e) {
    e.preventDefault();
    $(this).ekkoLightbox();
});

$('.btnsendemail').click(function (e) {
    e.preventDefault();
    if (!isValidEmailAddress($('#email_cli').val())) {
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
        url: "clients-send-email.php?subject=" + $('#subjectSM').val() + '&message=' + encodeURIComponent($('#messagemail').val().replace(/\r?\n/g, "<br>")) + '&email=' + $('#email_cli').val() + '&cco=' + $('#ccoEml').val() + '&tipo=7&lang=' + $('#idioma_cli').val() + '&usr=' + idClient,
        cache: false
    }).done(function (data) {
        if (data == 'ok') {
            alert(mensaSend);
            $('#subjectSM').val('');
            $('#messagemail').redactor('source.setCode', '');
            $('#form1 .loadingMail').remove();
        }
    });
});

$(document).on("click", "#proptabs a", function (e) { //user click on remove text
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
    if ($(this).attr('href') == '#tabcruce') {
        $('#interesados-tab').click();
    }
});
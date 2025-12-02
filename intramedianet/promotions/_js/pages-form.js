$(document).ready(function() {

    $(".multi_images").pluploadQueue({
      runtimes : 'html5,flash,silverlight,html4',
      url : '/intramedianet/news/images_upload.php?id_nws=' + idNews,
      max_file_size : '100mb',
      unique_names : true,
      multiple_queues: true,
      // browse_button : 'pickfiles',
      preinit : attachCallbacks,
      dragdrop: true,
      filters : {
        mime_types: [
          {title : "Image files", extensions : "jpg,jpeg,gif,png"}
        ]
      },
      resize : {width : 2000, height : 1200, quality : 90},
      flash_swf_url : '../includes/assets/swf/Moxie.swf',
      silverlight_xap_url : '../includes/assets/swf/Moxie.xap'
    });

    function attachCallbacks(uploader) {
      uploader.bind('FileUploaded', function(Up, File, Response) {
      if( (uploader.total.uploaded + 1) == uploader.files.length) {
        $.get("images_list.php?id_nws=" + idNews, function(data) {
          if(data != '') {
            $('#images-list').html(data);
          }
        });

      }
      });
    }

    $(".multi_files").pluploadQueue({
        runtimes : 'html5,flash,silverlight,html4',
        url : '/intramedianet/news/files_upload.php?id_nws=' + idNews,
        max_file_size : '100mb',
        unique_names : false,
        multiple_queues: true,
        preinit : attachCallbacks2,
        dragdrop: true,
        filters : {
          mime_types: [
            {title : "Files", extensions : "rar,txt,zip,doc,pdf,csv,xls,rtf,sxw,odt,docx,xlsx,ppt,mov"}
          ]
        },
        flash_swf_url : '../includes/assets/swf/Moxie.swf',
        silverlight_xap_url : '../includes/assets/swf/Moxie.xap'
    });

    function attachCallbacks2(uploader) {
      uploader.bind('FileUploaded', function(Up, File, Response) {
          if( (uploader.total.uploaded + 1) == uploader.files.length) {
              $.get("files_list.php?id_nws=" + idNews, function(data) {
                if(data != '') {
                    $('#file-list').html(data);
                }
              });
            }
        });
    }

    $(document).on('click', '.edit-alt', function(e) {
      e.preventDefault();
      tb = $(this);
      $('#myModal').modal('show').on('shown.bs.modal', function () {
        $.get('images_alts.php', { p: tb.attr('data-id') }, function(data) {
          $('#myModal .loadingfrm').css('background', '#fff').html(data);
        });
      }).on('hide.bs.modal', function () {
        var altsVals = $('#myModal :input').serialize();
        $.get('images_alts.php?' + altsVals,  function(data) {
          $('.loadingfrm').css('background', 'url(../includes/assets/img/loading_big.gif) no-repeat center center').html('');
          $.get("images_list.php?id_nws=" + idTeams, function(data) {
            if(data != '') {
              $('#images-list').html(data);
            }
          });
        });
      });
    });

    $(document).on('click', '.edit-name', function(e) {
      e.preventDefault();
      tb = $(this);
      $('#myModal2').modal('show').on('shown.bs.modal', function () {
        $.get('files_names.php', { p: tb.attr('data-id') }, function(data) {
          $('#myModal2 .loadingfrm').css('background', '#fff').html(data);
        });
      }).on('hide.bs.modal', function () {
        var altsVals = $('#myModal2 :input').serialize();
        $.get('files_names.php?' + altsVals, function(data) {
          $('.loadingfrm').css('background', 'url(../includes/assets/img/loading_big.gif) no-repeat center center').html('');
        });
      });
    });

    $(document).on('click', '.edit-lang', function(e) {
      e.preventDefault();
      tb = $(this);
      $('#myModalLang').modal('show').on('shown.bs.modal', myModalLangShowHandler).on('hide.bs.modal', myModalLangHideHandler);
    });

    function myModalLangShowHandler() {
        $.get('files_langs.php', { p: tb.attr('data-id') }, function(data) {
          $('#myModalLang .loadingfrm').css('background', '#fff').html(data);
        });
        $('#myModalLang').off('shown.bs.modal', myModalLangShowHandler);
    }

    function myModalLangHideHandler() {
        var nameVals = $('#myModalLang #langVals').serialize();
        $.get('files_langs.php?' + nameVals, function(data) {
          $.get("files_list.php?id_nws=" + idNews, function(data) {
            if(data != '') {
                $('#file-list').html(data);
                $('.loadingfrm').css('background', 'url(../includes/assets/img/loading_big.gif) no-repeat center center').html('');
            }
          });
        });

        $('#myModalLang').off('hide.bs.modal', myModalLangHideHandler);

    }

    var oTable, asInitVals = [], selected;

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
        "sAjaxSource": "properties-promotion-data.php?p="+idNews,
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
                        btns += '<li><a href="../properties/properties-form.php?id_prop=' + data + '&amp;KT_back=1" target="_blank" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
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

});

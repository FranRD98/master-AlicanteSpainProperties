function in_arrayf(needle, theFavs, theFavsNum){
    var found = 0;
    var theFavs = theFavs;
    for (var i=0;i<=theFavsNum;i++) {

        if (theFavs[i] == needle) {

            return i;

        }

        found++;
    }
    return -1;
}

$(document).ready(function() {

    $('#destacado_prop_sel').change(function(e) {

        $('#destacado_prop').val($(this).val()).trigger('keyup');

    });

    $('#force_hide_prop_sel').change(function(e) {

        $('#force_hide_prop').val($(this).val()).trigger('keyup');

    });

    $('#oferta_prop_sel').change(function(e) {

        $('#oferta_prop').val($(this).val()).trigger('keyup');

    });

    $('#activado_prop_sel').change(function(e) {

        $('#activado_prop').val($(this).val()).trigger('keyup');

    });

    var oTable, asInitVals = [];

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
        fnResetAllFilters()
    });

    function fnResetAllFilters() {
        var oSettings = oTable.fnSettings();
        for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
            oSettings.aoPreSearchCols[ iCol ].sSearch = '';
        }
        $('select').prop('selectedIndex',0);
        oTable.fnDraw();
    }

    if(numCols == 11) {
        var colDef = [
                {
                    "targets": 0,
                    "orderable": false,
                    "searchable": false,
                    "sClass": "imgprop"
                },
                {
                    "targets": [6, 7],
                    "visible": false,
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=destacado_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=destacado_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 9
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=activado_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=activado_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 10
                },
                {
                    "render": function ( data, type, row ) {
                        btns  = '<a href="properties-form.php?id_prop=' + row[numCols] + '&amp;KT_back=1" class="btn btn-success btn-sm btn-edit-info"><i class="fa fa-pencil"></i></a> ';
                        if (canDel == 1) {
                        btns += '<a href="properties-form.php?id_prop=' + row[numCols] + '&amp;KT_back=1&amp;KT_Delete1=1" class="btn btn-danger btn-sm delrow"><i class="fa fa-trash"></i></a> ';
                        }
                        // btns += '<a href="/intramedianet/properties/send-clients.php?id=' + row[numCols] + '" class="btn btn-primary btn-sm send-clients"><i class="fa fa-envelope"></i></a> ';
                        btns += '<div class="btn-group dropup">';
                        btns += '<button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">';
                        btns += '<i class="fa fa fa fa-print"></i> <span class="caret"></span></button>';
                        btns += '<ul class="dropdown-menu pull-right" role="menu" style="width: 350px;">';
                        for (var i = 0; i < langs.length; i++) {
                        btns += '<li class="clearfix">';
                            btns += '<a href="http://'+host+'/modules/property/save.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A4</a> ';
                            btns += '<a href="http://'+host+'/modules/property/save-mb.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A4 W</a> ';
                            btns += '<a href="http://'+host+'/modules/property/save-a3.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A3</a> ';
                            btns += '<a href="http://'+host+'/modules/property/save-a3-mb.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A3 W</a> ';
                        btns += '</li>';
                        }
                        btns += '</ul>';
                        btns += '</div>';
                        var theID = row[numCols];
                        if(in_arrayf(theID, theFavs, theFavsNum) == -1) {
                        btns  += '&nbsp;<a href="fav-add.php?favadm=' + row[numCols] + '" class="btn btn-info btn-sm"><i class="fa fa-star"></i></a> ';
                        } else {
                        btns  += '&nbsp;<a href="fav-del.php?favadm=' + row[numCols] + '" class="btn btn-danger btn-sm"><i class="fa fa-star"></i></a> ';
                        }
                        return  btns;
                    },
                    "targets": numCols,
                    "orderable": false,
                    "searchable": false
                }
            ]
    }


    if(numCols == 12 && showprecioReduc == 1 && xmlImport == 0) {
        var colDef = [
                {
                    "targets": 0,
                    "orderable": false,
                    "searchable": false,
                    "sClass": "imgprop"
                },
                {
                    "targets": [6, 7],
                    "visible": false,
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=destacado_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=destacado_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 9
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=activado_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=activado_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 10
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=oferta_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=oferta_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 11
                },
                {
                    "render": function ( data, type, row ) {
                        btns  = '<a href="properties-form.php?id_prop=' + row[numCols] + '&amp;KT_back=1" class="btn btn-success btn-sm btn-edit-info"><i class="fa fa-pencil"></i></a> ';
                        btns += '<a href="properties-form.php?id_prop=' + row[numCols] + '&amp;KT_back=1&amp;KT_Delete1=1" class="btn btn-danger btn-sm delrow"><i class="fa fa-trash"></i></a> ';
                        // btns += '<a href="/intramedianet/properties/send-clients.php?id=' + row[numCols] + '" class="btn btn-primary btn-sm send-clients"><i class="fa fa-envelope"></i></a> ';
                        btns += '<div class="btn-group dropup">';
                        btns += '<button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">';
                        btns += '<i class="fa fa fa fa-print"></i> <span class="caret"></span></button>';
                        btns += '<ul class="dropdown-menu pull-right" role="menu" style="width: 350px;">';
                        for (var i = 0; i < langs.length; i++) {
                            btns += '<li class="clearfix">';
                                btns += '<a href="http://'+host+'/modules/property/save.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A4</a> ';
                                btns += '<a href="http://'+host+'/modules/property/save-mb.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A4 W</a> ';
                                btns += '<a href="http://'+host+'/modules/property/save-a3.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A3</a> ';
                                btns += '<a href="http://'+host+'/modules/property/save-a3-mb.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A3 W</a> ';
                            btns += '</li>';
                        }
                        btns += '</ul>';
                        btns += '</div>';
                        var theID = row[numCols];
                        if(in_arrayf(theID, theFavs, theFavsNum) == -1) {
                        btns  += '&nbsp;<a href="fav-add.php?favadm=' + row[numCols] + '" class="btn btn-info btn-sm"><i class="fa fa-star"></i></a> ';
                        } else {
                        btns  += '&nbsp;<a href="fav-del.php?favadm=' + row[numCols] + '" class="btn btn-danger btn-sm"><i class="fa fa-star"></i></a> ';
                        }
                        return  btns;
                    },
                    "targets": numCols,
                    "orderable": false,
                    "searchable": false
                }
            ]
    }

    if(numCols == 15 && showprecioReduc == 0 && xmlImport == 1) {
        var colDef = [
                {
                    "targets": 0,
                    "orderable": false,
                    "searchable": false,
                    "sClass": "imgprop"
                },
                {
                    "targets": [6, 7],
                    "visible": false,
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=destacado_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=destacado_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 9
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=activado_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=activado_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 10
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=force_hide_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=force_hide_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 11
                },
                {
                    "render": function ( data, type, row ) {
                        btns  = '<a href="properties-form.php?id_prop=' + row[numCols] + '&amp;KT_back=1" class="btn btn-success btn-sm btn-edit-info"><i class="fa fa-pencil"></i></a> ';
                        btns += '<a href="properties-form.php?id_prop=' + row[numCols] + '&amp;KT_back=1&amp;KT_Delete1=1" class="btn btn-danger btn-sm delrow"><i class="fa fa-trash"></i></a> ';
                        // btns += '<a href="/intramedianet/properties/send-clients.php?id=' + row[numCols] + '" class="btn btn-primary btn-sm send-clients"><i class="fa fa-envelope"></i></a> ';
                        btns += '<div class="btn-group dropup">';
                        btns += '<button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">';
                        btns += '<i class="fa fa fa fa-print"></i> <span class="caret"></span></button>';
                        btns += '<ul class="dropdown-menu pull-right" role="menu" style="width: 350px;">';
                        for (var i = 0; i < langs.length; i++) {
                            btns += '<li class="clearfix">';
                                btns += '<a href="http://'+host+'/modules/property/save.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A4</a> ';
                                btns += '<a href="http://'+host+'/modules/property/save-mb.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A4 W</a> ';
                                btns += '<a href="http://'+host+'/modules/property/save-a3.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A3</a> ';
                                btns += '<a href="http://'+host+'/modules/property/save-a3-mb.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A3 W</a> ';
                            btns += '</li>';
                        }
                        btns += '</ul>';
                        btns += '</div>';
                        var theID = row[numCols];
                        if(in_arrayf(theID, theFavs, theFavsNum) == -1) {
                        btns  += '&nbsp;<a href="fav-add.php?favadm=' + row[numCols] + '" class="btn btn-info btn-sm"><i class="fa fa-star"></i></a> ';
                        } else {
                        btns  += '&nbsp;<a href="fav-del.php?favadm=' + row[numCols] + '" class="btn btn-danger btn-sm"><i class="fa fa-star"></i></a> ';
                        }
                        return  btns;
                    },
                    "targets": numCols,
                    "orderable": false,
                    "searchable": false
                }
            ]
    }

    if(numCols == 16 && showprecioReduc == 1 && xmlImport == 1) {
        var colDef = [
                {
                    "targets": 0,
                    "orderable": false,
                    "searchable": false,
                    "sClass": "imgprop"
                },
                {
                    "targets": [6, 7],
                    "visible": false,
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=destacado_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=destacado_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 9
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=activado_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=activado_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 10
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=oferta_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=oferta_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 11
                },
                {
                    "render": function ( data, type, row ) {
                        if (data == 'No') {
                            btns  = '<a href="properties-change.php?s=force_hide_prop&v=1&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/delete.gif" alt=""></a>';
                        } else{
                            btns  = '<a href="properties-change.php?s=force_hide_prop&v=0&id_prop=' +  row[numCols] + '" class="update-status"><img src="/intramedianet/includes/assets/img/done.gif" alt=""></a>';
                        }
                        return  btns;
                    },
                    "targets": 12
                },
                {
                    "render": function ( data, type, row ) {
                        btns  = '<a href="properties-form.php?id_prop=' + row[numCols] + '&amp;KT_back=1" class="btn btn-success btn-sm btn-edit-info"><i class="fa fa-pencil"></i></a> ';
                        btns += '<a href="properties-form.php?id_prop=' + row[numCols] + '&amp;KT_back=1&amp;KT_Delete1=1" class="btn btn-danger btn-sm delrow"><i class="fa fa-trash"></i></a> ';
                        // btns += '<a href="/intramedianet/properties/send-clients.php?id=' + row[numCols] + '" class="btn btn-primary btn-sm send-clients"><i class="fa fa-envelope"></i></a> ';
                        btns += '<div class="btn-group dropup">';
                        btns += '<button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">';
                        btns += '<i class="fa fa fa fa-print"></i> <span class="caret"></span></button>';
                        btns += '<ul class="dropdown-menu pull-right" role="menu" style="width: 350px;">';
                        for (var i = 0; i < langs.length; i++) {
                            btns += '<li class="clearfix">';
                                btns += '<a href="http://'+host+'/modules/property/save.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A4</a> ';
                                btns += '<a href="http://'+host+'/modules/property/save-mb.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A4 W</a> ';
                                btns += '<a href="http://'+host+'/modules/property/save-a3.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A3</a> ';
                                btns += '<a href="http://'+host+'/modules/property/save-a3-mb.php?id=' + row[numCols] + '&lang=' + langs[i] + '" target="_blank" style="float:left; clear:none;"><img src="/intramedianet/includes/assets/img/flags-langs/' + langs[i] + '.png" alt=""> A3 W</a> ';
                            btns += '</li>';
                        }
                        btns += '</ul>';
                        btns += '</div>';
                        var theID = row[numCols];
                        if(in_arrayf(theID, theFavs, theFavsNum) == -1) {
                        btns  += '&nbsp;<a href="fav-add.php?favadm=' + row[numCols] + '" class="btn btn-info btn-sm"><i class="fa fa-star"></i></a> ';
                        } else {
                        btns  += '&nbsp;<a href="fav-del.php?favadm=' + row[numCols] + '" class="btn btn-danger btn-sm"><i class="fa fa-star"></i></a> ';
                        }
                        return  btns;
                    },
                    "targets": numCols,
                    "orderable": false,
                    "searchable": false
                }
            ]
    }

    oTable = $('#records-tables').dataTable({
        "sAjaxSource": "properties-data.php",
        dom: "lC" +
             "<'row'<'col-sm-12 table-responsive'tr>>" +
             "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "oColVis": {
            "aiExclude": [ numCols ],
            "buttonText": "<i class=\"fa fa-table\"></i>",
            "sAlign": "right",
            "fnStateChange": function ( iColumn, bVisible ) {
                toggleScrollBarIcon();
            }
        },
        "order": [[ 1, "asc" ]],
        "bSortCellsTop": true,
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                }
            }
            toggleScrollBarIcon();
            $(document).delegate('*[data-toggle="lightbox"]', 'click', function(e) {
                e.preventDefault();
                $(this).ekkoLightbox();
            });

            if ($('#destacado_prop').val() != '') {

                $('#destacado_prop_sel').val($('#destacado_prop').val() );

            }

            if ($('#force_hide_prop').val() != '') {

                $('#force_hide_prop_sel').val($('#force_hide_prop').val() );

            }

            if ($('#oferta_prop').val() != '') {

                $('#oferta_prop_sel').val($('#oferta_prop').val() );

            }

            if ($('#activado_prop').val() != '') {

                $('#activado_prop_sel').val($('#activado_prop').val() );

            }

            $('[data-toggle="tooltip"]').tooltip();

        },
        "columnDefs": colDef

    });

    $("#records-tables_length").appendTo("#col-1");
    $(".ColVis").appendTo("#col-2");

});

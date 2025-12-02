$(document).ready(function() {

    $(window).change('.search-inputs select', function(e) {
        var current = $(e.target);
        $(current).prev().val($(current).val()).trigger('keyup');
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

    oTable = $('#records-tables').dataTable({
        "sAjaxSource": "news-data.php",
        "bSortCellsTop": true,
         "order": [[ 0, 'asc' ]],
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                }
            }
            toggleScrollBarIcon();
        },
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                    var changeV = data == non ? 2: 0;
                    if (data == non) {
                        var bntImage = '<div class="text-center mt-1"><a href="developments-change.php?s=activate_nws&v='+changeV+'&id_prop=' +  row[numCols] + '" class="update-status"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></a></div>';
                    } else {
                        if (data == 2) {
                            bntImage = '<div class="text-center mt-1"><a href="developments-change.php?s=activate_nws&v=0&id_prop=' +  row[numCols] + '" class="update-status"><i class="fa-solid fa-spinner fa-spin-pulse fs-4 fw-bolder"></i></a></div>';
                        } else {
                            bntImage = '<div class="text-center mt-1"><a href="developments-change.php?s=activate_nws&v='+changeV+'&id_prop=' +  row[numCols] + '" class="update-status"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></a></div>';
                        }
                    }
                    return bntImage;
                },
                "targets": numCols - 1
            },
            {
                "render": function ( data, type, row ) {
                    btns = '';
                    if (row[numCols - 1] != non) {
                        btns += '<div class="dropdown d-inline-block w-100">';
                            btns += '<button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                                btns += '<i class="fa-regular fa-ellipsis align-middle"></i>';
                            btns += '</button>';
                            btns += '<ul class="dropdown-menu dropdown-menu-end">';
                                btns += '<li><a href="news-form.php?id_nws=' + data + '&amp;KT_back=1" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
                                if (canDel == 1) {
                                    btns += '<li><hr class="dropdown-divider"></li>';
                                    btns += '<li><a href="news-form.php?id_nws=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                                }
                            btns += '</ul>';
                        btns += '</div>';
                    }
                    return  btns;
                },
                "targets": numCols,
                "orderable": false,
                "className": "actions"
            }
        ]
    });

    $("#records-tables_length").appendTo("th#actions");

});

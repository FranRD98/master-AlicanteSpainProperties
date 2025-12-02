$(document).ready(function() {

    var oTable, asInitVals = [];

    $("thead input").keyup( function () {
        oTable.fnFilter( this.value, oTable.oApi._fnVisibleToColumnIndex(
            oTable.fnSettings(), $("thead input").index(this) ) );
    });

    $('#active_fair_sts_sel').change(function(e) {
        $('#active_fair_sts').val($(this).val()).trigger('keyup');
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
        oTable.fnDraw();
    }

   var aoCols = [];

    aoCols.push(null);

    if (totalColumns === 3) {
        aoCols.push({
        "bSearchable": false,
        "bSortable": false,
        "sClass": "text-center",
        "render": function ( data, type, row ) {
            if (!data || data.trim() === non.trim()) {
                return '<div class="mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div>';
            } else {
                return '<div class="mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div>';
            }
        }
        });
    }

    aoCols.push({
        "bSearchable": false,
        "bSortable": false,
        "sClass": "actions",
        "render": function ( data, type, row ) {
            btns = '<div class="dropdown d-inline-block w-100">';
                btns += '<button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                    btns += '<i class="fa-regular fa-ellipsis align-middle"></i>';
                btns += '</button>';
                btns += '<ul class="dropdown-menu dropdown-menu-end">';
                    btns += '<li><a href="clients-sources-form.php?id_sts=' + data + '&amp;KT_back=1" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
                    if (canDel == 1) {
                        btns += '<li><hr class="dropdown-divider"></li>';
                        btns += '<li><a href="clients-sources-form.php?id_sts=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                    }
                btns += '</ul>';
            btns += '</div>';
            return  btns;
        }
    });

    oTable = $('#records-tables').dataTable({
        "sAjaxSource": "clients-sources-data.php",
        "bSortCellsTop": true,
        "aoColumns": aoCols,
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                }
            }
            toggleScrollBarIcon();
            if ($('#active_fair_sts').val() != '') {
                $('#active_fair_sts_sel').val($('#active_fair_sts').val() );
            }
        }
    });

    $("#records-tables_length").appendTo("th#actions");

});

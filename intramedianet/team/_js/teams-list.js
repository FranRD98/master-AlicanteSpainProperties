$(document).ready(function() {

    $('#activate_tms_sel').change(function(e) {
        $('#activate_tms').val($(this).val()).trigger('keyup');
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
        oTable.fnDraw();
        $('select').prop('selectedIndex',0);
    }

    oTable = $('#records-tables').dataTable({
        "sAjaxSource": "teams-data.php",
        "bSortCellsTop": true,
         "order": [[ numCols - 1 , "DESC" ]],
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                }
            }
            toggleScrollBarIcon();
            if ($('#activate_tms').val() != '') {
                $('#activate_tms_sel').val($('#activate_tms').val() );
            }
        },
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                    if (data == non) {
                        btns  = '<div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div>';
                    } else{
                        btns  = '<div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div>';
                    }
                    return  btns;
                },
                "targets": numCols - 1
            },
            {
                "render": function ( data, type, row ) {

                    btns = '<div class="dropdown d-inline-block w-100">';
                        btns += '<button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                            btns += '<i class="fa-regular fa-ellipsis align-middle"></i>';
                        btns += '</button>';
                        btns += '<ul class="dropdown-menu dropdown-menu-end">';
                            btns += '<li><a href="teams-form.php?id_tms=' + data + '&amp;KT_back=1" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
                            if (canDel == 1) {
                                btns += '<li><hr class="dropdown-divider"></li>';
                                btns += '<li><a href="teams-form.php?id_tms=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                            }
                        btns += '</ul>';
                    btns += '</div>';
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

 $(document).ready(function() {

    var oTable, asInitVals = [];

    $('#nivel_usr_sel').change(function(e) {

        $('#nivel_usr').val($(this).val()).trigger('keyup');

    });

    $('#activar_usr_sel').change(function(e) {

        $('#activar_usr').val($(this).val()).trigger('keyup');

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
        "sAjaxSource": "users-data.php",
        "bSortCellsTop": true,
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                }
            }
            if ($('#nivel_usr').val() != '') {
                $('#nivel_usr_sel').val($('#nivel_usr').val() );
            }
            if ($('#activar_usr').val() != '') {
                $('#activar_usr_sel').val($('#activar_usr').val() );
            }
            toggleScrollBarIcon();
        },
        "aoColumns": [
            null,
            null,
            {
                "mRender": function (data, type, full) {
                    if (data == non) {
                        btns  = '<div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div>';
                    } else{
                        btns  = '<div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div>';
                    }
                    return  btns;
                }
            },
            {
                "sType": "date-eu-pre"
            },
            {
                "bSearchable": false,
                "bSortable": false,
                "sClass": "actions",
                "mRender": function (data, type, full) {
                    btns = '<div class="dropdown d-inline-block w-100">';
                        btns += '<button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                            btns += '<i class="fa-regular fa-ellipsis align-middle"></i>';
                        btns += '</button>';
                        btns += '<ul class="dropdown-menu dropdown-menu-end">';
                            btns += '<li><a href="users-form.php?id_usr=' + data + '&amp;KT_back=1" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
                            btns += '<li><hr class="dropdown-divider"></li>';
                            btns += '<li><a href="users-form.php?id_usr=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                        btns += '</ul>';
                    btns += '</div>';
                    return  btns;
                }
            }
        ]
    });

    $("#records-tables_length").appendTo("th#actions");

});

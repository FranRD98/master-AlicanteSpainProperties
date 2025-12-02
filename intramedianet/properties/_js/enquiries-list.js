 $(document).ready(function() {

    $('#read_cons_sel').change(function(e) {

        $('#read_cons').val($(this).val()).trigger('keyup');

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
        "sAjaxSource": "enquiries-data.php",
        "bSortCellsTop": true,
     "aaSorting": [[ 4, "DESC" ]],
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                }
            }
            if ($('#read_cons').val() != '') {
                $('#read_cons_sel').val($('#read_cons').val() );
            }
            toggleScrollBarIcon();
        },
        "aoColumns": [
            {
                "mRender": function (data, type, full) {
                    return '<a href="/intramedianet/properties/properties-form.php?id_prop=' + full[7] + '&KT_back=1" class="btn btn-soft-primary btn-sm"><i class="fa fa-building-o"></i> ' + data + '</a> <a href="/intramedianet/properties/enquiries-form.php?id_cons=' + full[7] + '&KT_back=1" class="btn btn-success btn-sm d-md-none mt-2 mt-md-0 w-100"><i class="fa fa-pencil"></i> ' + dtEditar + '</a>';
                }
            },
            null,
            null,
            null,
            null,
            {

            "sClass": "ticks",
            "mRender": function (data, type, full) {
                if (data == '0') {
                    return '<a href="enquiries-change.php?s=read_cons&v=1&id_cons=' + full[6] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';
                } else{
                    return '<a href="enquiries-change.php?s=read_cons&v=0&id_cons=' + full[6] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';
                }                }
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
                                btns += '<li><a href="enquiries-form.php?id_cons=' + data + '&amp;KT_back=1" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
                                if (canDel == 1) {
                                    btns += '<li><hr class="dropdown-divider"></li>';
                                    btns += '<li><a href="enquiries-form.php?id_cons=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                                }
                            btns += '</ul>';
                        btns += '</div>';
                        return  btns;
                    }
            }
        ]
    });

    $("#records-tables_length").appendTo("th#actions");

});

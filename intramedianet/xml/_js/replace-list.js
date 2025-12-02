$(document).ready(function() {

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
    }

    oTable = $('#records-tables').dataTable({
        "sAjaxSource": "replace-data.php",
        "bSortCellsTop": true,
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                }
            }
            toggleScrollBarIcon();
        },
        "aoColumns": [
            null,
            null,
            {
                "bSearchable": false,
                "bSortable": false,
                "sClass": "actions",
                "mRender": function (data, type, full) {
                        btns  = '<a href="replace-form.php?id_rep=' + data + '&amp;KT_back=1" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a> ';
                        btns += '<a href="replace-form.php?id_rep=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="btn btn-danger btn-sm delrow"><i class="fa fa-trash-o"></i></a> ';
                        return  btns;
                    }
            }
        ]
    });

    $("#records-tables_length").appendTo("th#actions");

});
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
        oTable.fnDraw();
    }

    oTable = $('#records-tables').dataTable({
        "sAjaxSource": "clients-rates-data.php",
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
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                    btns  = '<a href="/intramedianet/properties/clients-form.php?id_cli=' + data + '&amp;KT_back=1" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a> ';
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

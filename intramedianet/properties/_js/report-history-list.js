$(document).ready(function() {

    $('#accion_sel').change(function(e) {

        $('#accion').val($(this).val()).trigger('keyup');

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
        "sAjaxSource": "history-data.php",
        "bSortCellsTop": true,
        dom: "" +
         "<'row'<'col-sm-12 table-responsive'tr>>" +
         "<'row'<'col-sm-6'il><'col-sm-6'p>>",
          "order": [[ 3, "asc" ]],
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                }
            }

            toggleScrollBarIcon();

            if ($('#accion').val() != '') {

                $('#accion_sel').val($('#accion').val() );

            }
        },
        "aoColumns": [
            null,
            null,
            null,
            null
        ]
    });

    $("#records-tables_length").appendTo(".panel-heading");

});